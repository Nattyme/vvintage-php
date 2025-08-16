<?php
declare(strict_types=1);

namespace Vvintage\Repositories\PostCategory;

use RedBeanPHP\R;
use RedBeanPHP\OODBBean;
use Vvintage\Contracts\PostCategory\PostCategoryRepositoryInterface;
use Vvintage\Repositories\AbstractRepository;
use Vvintage\Models\PostCategory\PostCategory;
use Vvintage\DTO\PostCategory\PostCategoryDTO;

final class PostCategoryRepository extends AbstractRepository implements PostCategoryRepositoryInterface
{
    private const TABLE = 'postscategories';
    private const TABLE_TRANSLATION = 'postscategoriestranslation';

    private string $currentLang;
    private const DEFAULT_LANG = 'ru';



    public function __construct(string $currentLang = self::DEFAULT_LANG)
    {
        $this->currentLang = $currentLang;
    }



    public function getPostCatById(int $id): ?PostCategory
    {
        $bean = $this->findById(self::TABLE, $id);

        if (!$bean || !$bean->id) {
            return null;
        }

        return $this->mapBeanToPostCategory($bean);
    }

    
    public function getAllCategories(): array
    {
        $beans = $this->findAll(self::TABLE);
        return array_map([$this, 'mapBeanToPostCategory'], $beans);
    }

    public function getPostCatsByIds(array $ids): array
    {
        $beans = $this->findByIds(self::TABLE, $ids);
        return array_map([$this, 'mapBeanToPostCategory'], $beans);
    }


    public function getPostCatsByParentId(?int $id = null): array
    {
        if ($id === null) {
            $beans = $this->findAll(self::TABLE, 'parent_id IS NULL');
        } else {
            $beans = $this->findAll(self::TABLE, 'parent_id = ?', [$id]);
        }

        return array_map([$this, 'mapBeanToPostCategory'], $beans);
    }

    public function getMainCats(): array
    {
        $rows = $this->unitePostRawData();

        $mainCategories = array_filter($rows, function ($row) {
            return $row['parent_id'] === null;
        });

        return array_map([$this, 'mapArrayToPostCategory'], $mainCategories);
    }

    public function getParentCategory(PostCategory $childCategrory): ?PostCategory
    {
      $mainCatId =  $childCategrory->getId();
      return $this->getPostCatById($mainCatId);
    }

    

    public function getSubCats(): array
    {
        $rows = $this->unitePostRawData();

        $subCategories = array_filter($rows, function ($row) {
            return $row['parent_id'] !== null;
        });

        return array_map([$this, 'mapArrayToPostCategory'], $subCategories);
    }


    public function savePostCat(PostCategory $cat): int
    {
        $bean = $cat->getId()
            ? $this->loadBean(self::TABLE, $cat->getId())
            : $this->createBean(self::TABLE);

        $bean->title = $cat->getTitle();
        $bean->parent_id = $cat->getParentId();
        $bean->image = $cat->getImage();
        $bean->seo_title = $cat->getSeoTitle();
        $bean->seo_description = $cat->getSeoDescription();

        $id = (int) $this->saveBean($bean);

        // Сохраняем переводы
        R::exec('DELETE FROM ' . self::TABLE_TRANSLATION . ' WHERE category_id = ?', [$id]);

        foreach ($cat->getAllTranslations() as $locale => $translation) {
            $transBean = $this->createBean(self::TABLE_TRANSLATION);
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

    private function loadTranslations(int $categoryId): array
    {
        $rows = R::getAll(
            'SELECT locale, title, description, meta_title, meta_description 
             FROM ' . self::TABLE_TRANSLATION . ' WHERE category_id = ?',
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

    private function createCategoryDTOFromArray(array $row): PostCategoryDTO
    {
        $locale = $this->currentLang ?? self::DEFAULT_LANG;

        return new PostCategoryDTO([
            'id' => (int) $row['id'],
            'title' => (string) ($row['category_title_translation'] ?? ''),
            'parent_id' => (int) ($row['parent_id'] ?? 0),
            'image' => (string) ($row['image'] ?? ''),
            'slug' => (string) ($row['slug'] ?? ''),
            'translations' => [
                $locale => [
                    'slug' => $row['slug'] ?? '',
                    'title' => $row['category_title_translation'] ?? '',
                    'description' => $row['category_description'] ?? '',
                    'seo_title' => $row['category_meta_title'] ?? '',
                    'seo_description' => $row['category_meta_description'] ?? '',
                ]
            ],
        ]);
    }

    private function mapArrayToPostCategory(array $row): PostCategory
    {
        $dto = $this->createCategoryDTOFromArray($row);
        return PostCategory::fromDTO($dto);
    }

    private function mapBeanToPostCategory(OODBBean $bean): PostCategory
    {
        $translations = $this->loadTranslations((int) $bean->id);

        $dto = new PostCategoryDTO([
            'id' => (int) $bean->id,
            'title' => (string) $bean->title,
            'parent_id' => (int) $bean->parent_id,
            'image' => (string) $bean->image,
            'slug' => '', 
            'translations' => $translations,
        ]);

        return PostCategory::fromDTO($dto);
    }

    private function unitePostRawData(?int $categoryId = null): array
    {
        $sql = '
            SELECT 
                c.*,
                ct.title AS category_title_translation,
                ct.description AS category_description,
                ct.meta_title AS category_meta_title,
                ct.meta_description AS category_meta_description
            FROM ' . self::TABLE .' c
            LEFT JOIN ' . self::TABLE_TRANSLATION .' ct ON ct.category_id = c.id AND ct.locale = ?
        ';

        $locale = $this->currentLang ?? self::DEFAULT_LANG;
        $bindings = [$locale];

        if ($categoryId !== null) {
            $sql .= ' WHERE c.id = ? GROUP BY c.id LIMIT 1';
            $bindings[] = $categoryId;
            $row = R::getRow($sql, $bindings);

            return $row ? [$row] : [];
        } else {
            $sql .= ' GROUP BY c.id ORDER BY c.id DESC';
            return R::getAll($sql, $bindings);
        }
    }

    public function getAllCategoriesCount (?string $sql = null, array $params = []): int
    {
      return $this->countAll(self::TABLE, $sql, $params);
    }

    
}
