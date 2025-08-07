<?php
declare(strict_types=1);

namespace Vvintage\Repositories\PostCategory;

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
  // СОЗДАТЬ ТАБЛИЦУ ПЕРЕВОДО КАТЕГОРИЙ ПОСТОВ
    private const TABLE_CATEGORIES = 'posts_categories';
    private const TABLE_CATEGORIES_TRANSLATION = 'posts_categories_translation';
    private string $currentLang;
    private const DEFAULT_LANG = 'ru';

    public function __construct(string $currentLang = self::DEFAULT_LANG)
    {
        $this->currentLang = $currentLang;
    }


    public function getPostCatById(int $id): ?PostCategory
    {
        $bean = $this->findById(self::TABLE_CATEGORIES, $id);

        if (!$bean || !$bean->id) {
            return null;
        }

        return $this->mapBeanToPostCategory($bean);
    }

    public function getAllPostCats(): array
    {
        $beans = $this->findAll(self::TABLE_CATEGORIES);
        return array_map([$this, 'mapBeanToPostCategory'], $beans);
    }

    public function getPostCatsByIds(array $ids): array
    {
        $beans = $this->findByIds(self::TABLE_CATEGORIES, $ids);
        return array_map([$this, 'mapBeanToPostCategory'], $beans);
    }

    public function getMainCats(): array
    {
        return $this->findAll(self::TABLE_CATEGORIES, 'WHERE parent_id IS NULL', []);
    }

    public function getSubCats(): array
    {
      return $this->findAll(self::TABLE_CATEGORIES, 'WHERE parent_id IS NOT NULL', []);
    }


    public function getPostCatsByParentId(?int $id = null): array
    {
        if ($id === null) {
            $beans = $this->findAll(self::TABLE_CATEGORIES, 'parent_id IS NULL');
        } else { 
            $beans = $this->findAll(self::TABLE_CATEGORIES, 'parent_id = ?', [$id]);
        }

        return array_map([$this, 'mapBeanToPostCategory'], $beans);
    }


    public function savePostCat(Category $cat): int
    {
        $bean = $cat->getId() 
        ? $this->loadBean(self::TABLE_CATEGORIES, $cat->getId())
        : $this->createBean(self::TABLE_CATEGORIES);

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
            'SELECT locale, title, description, meta_title, meta_description 
             FROM ' . self::TABLE_CATEGORIES_TRANSLATION . ' WHERE category_id = ?',
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

    private function mapBeanToPostCategory(OODBBean $bean): PostCategory
    {
        $translations = $this->loadTranslations((int) $bean->id);

        $dto = new PostCategoryDTO([
            'id' => (int) $bean->id,
            'title' => (string) $bean->title,
            'parent_id' => (int) $bean->parent_id,
            'image' => (string) $bean->image,
            'translations' => $translations,
            'seo_title' => $bean->seo_title ?? '',
            'seo_description' => $bean->seo_description ?? '',
        ]);

        return PostCategory::fromDTO($dto);
    }
}
