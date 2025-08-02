<?php
declare(strict_types=1);

namespace Vvintage\Repositories;

use RedBeanPHP\R;
use RedBeanPHP\OODBBean;


/** Контракты */
use Vvintage\Contracts\PostCategory\PostCategoryRepositoryInterface;

/** Абстрактный репозиторий */
use Vvintage\Repositories\AbstractRepository;

/** Модель */
use Vvintage\Models\PostCategory\PostCategory;

/** DTO */
use Vvintage\DTO\PostCategory\PostCategoryDTO;



final class PostCategoryRepository extends AbstractRepository implements PostCategoryRepositoryInterface
{
    public function getPostCatById(int $id): ?PostCategory
    {
        $bean = $this->findById('posts_categories', $id);

        if (!$bean || !$bean->id) {
            return null;
        }

        return $this->mapBeanToPostCategory($bean);
    }

    public function getAllPostCats(): array
    {
        $beans = $this->findAll('posts_categories');
        return array_map([$this, 'mapBeanToPostCategory'], $beans);
    }

    public function getPostCatsByIds(array $ids): array
    {
        $beans = $this->findByIds('posts_categories', $ids);
        return array_map([$this, 'mapBeanToPostCategory'], $beans);
    }

    public function getMainCats(): array
    {
        return $this->findCatsByParentId();
    }

    public function getSubCats(): array
    {
        $beans = $this->findAll('posts_categories', 'parent_id IS NOT NULL');

        return array_map([$this, 'mapBeanToPostCategory'], $beans);
    }

    public function getPostCatsByParentId(?int $id = null): array
    {
        if ($id === null) {
            $beans = $this->findAll('posts_categories', 'parent_id IS NULL');
        } else {
            $beans = $this->findAll('posts_categories', 'parent_id = ?', [$id]);
        }

        return array_map([$this, 'mapBeanToPostCategory'], $beans);
    }


    public function savePostCat(Category $cat): int
    {
        $bean = $cat->getId() ? $this->loadBean('posts_categories', $cat->getId()) : $this->createBean('posts_categories');

        $bean->title = $cat->getTitle(); // по умолчанию ru
        $bean->parent_id = $cat->getParentId();
        $bean->image = $cat->getImage();
        $bean->seo_title = $cat->getSeoTitle();
        $bean->seo_description = $cat->getSeoDescription();

        $id = (int) $this->saveBean($bean);

        // Сохраняем переводы в отдельную таблицу
        R::exec('DELETE FROM categories_translation WHERE category_id = ?', [$id]);
        foreach ($cat->getAllTranslations() as $locale => $translation) {
            $transBean = $this->createBean('categories_translation');
            $transBean->category_id = $id;
            $transBean->locale = $locale;
            $transBean->title = $translation['title'] ?? '';
            $transBean->description = $translation['description'] ?? '';
            $transBean->meta_title = $translation['meta_title'] ?? '';
            $transBean->meta_description = $translation['meta_description'] ?? '';
            $this->saveBean($transBean);
        }

        return $id;
    }

    /**
     * Загружает переводы из categories_translation
     */
    private function loadTranslations(int $categoryId): array
    {
        $rows = R::getAll(
            'SELECT locale, title, description, meta_title, meta_description FROM categories_translation WHERE category_id = ?',
            [$categoryId]
        );

        $translations = [];
        foreach ($rows as $row) {
            $translations[$row['locale']] = [
                'title' => $row['title'],
                'description' => $row['description'],
                'meta_title' => $row['meta_title'],
                'meta_description' => $row['meta_description'],
            ];
        }

        return $translations;
    }

    private function mapBeanToPostCategory(OODBBean $bean): Category
    {
        $translations = $this->loadTranslations((int) $bean->id);

        $dto = new CategoryDTO([
            'id' => (int) $bean->id,
            'title' => (string) $bean->title,
            'parent_id' => (int) $bean->parent_id,
            'image' => (string) $bean->image,
            'translations' => $translations,
            'seo_title' => $bean->seo_title ?? '',
            'seo_description' => $bean->seo_description ?? '',
        ]);

        return Category::fromDTO($dto);
    }
}
