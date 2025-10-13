<?php
declare(strict_types=1);

namespace Vvintage\Repositories\PostCategory;

use RedBeanPHP\R;
use RedBeanPHP\OODBBean;
use Vvintage\Contracts\PostCategory\PostCategoryRepositoryInterface;
use Vvintage\Repositories\AbstractRepository;
use Vvintage\Models\PostCategory\PostCategory;
use Vvintage\DTO\PostCategory\PostCategoryDTO;
use Vvintage\DTO\PostCategory\PostCategoryInputDTO;
use Vvintage\DTO\PostCategory\PostCategoryOutputDTO;


// final class PostCategoryRepository extends AbstractRepository implements PostCategoryRepositoryInterface
final class PostCategoryRepository extends AbstractRepository 
{
    private const TABLE = 'postscategories';
    // private const TABLE_TRANSLATION = 'postscategoriestranslation';

    // private function loadTranslations(int $categoryId): array
    // {
    //     $sql =  'SELECT locale, title, description, meta_title, meta_description 
    //          FROM ' . self::TABLE_TRANSLATION . ' WHERE category_id = ?';

    //     $rows = $this->getAll($sql, [$categoryId]);

    //     $translations = [];

    //     foreach ($rows as $row) {
    //         $translations[$row['locale']] = [
    //             'title' => $row['title'],
    //             'description' => $row['description'],
    //             'meta_title' => $row['meta_title'],
    //             'meta_description' => $row['meta_description'],
    //         ];
    //     }

    //     return $translations;
    // }

    // private function mapBeanToPostCategory(OODBBean $bean): PostCategory
    // {
    //     $translations = $this->loadTranslations((int) $bean->id);

    //     $translatedData = $translations[$this->currentLang] ?? $translations[self::DEFAULT_LANG] ?? [
    //       'title' => '',
    //       'description' => '',
    //       'meta_title' => '',
    //       'meta_description' => ''
    //     ];

    //     $dto = new PostCategoryInputDTO([
    //         'id' => (int) $bean->id,
    //         'title' => (string) $bean->title,
    //         'parent_id' => (int) $bean->parent_id,
    //         'image' => (string) $bean->image,
    //         'slug' => '', 
    //         'translations' => $translations,
    //     ]);

    //     return PostCategory::fromDTO($dto);
    // }

    public function getCategoryById(int $id): ?PostCategory
    {
        $bean = $this->findById(self::TABLE, $id);

        if (!$bean || !$bean->id) {
            return null;
        }

        return PostCategory::fromBean($bean);
    }


    public function getCategoryBySlug(string $slug): ?PostCategory
    {
        $bean = $this->findOneBy(self::TABLE, 'slug = ?', [$slug]);

        if (!$bean || !$bean->id) {
            return null;
        }

        return PostCategory::fromBean($bean);
    }

    public function getMainCats(): array
    {
        return $this->findCatsByParentId();
    }

    public function getSubCats(): array
    {
        $beans = $this->findAll(table: self::TABLE, conditions: ['parent_id IS NOT NULL']);
        return array_map(fn($bean) => PostCategory::fromBean($bean), $beans);
    }

    public function findCatsByParentId(?int $parentId = null): array
    {
        if ($parentId === null) {
            // $beans = $this->findAll(table: self::TABLE, 'parent_id IS NULL');
            $beans = $this->findAll(table: self::TABLE, conditions: ['parent_id IS NULL']);
        } else {
            // $beans = $this->findAll(self::TABLE, 'parent_id = ?', [$parentId]);
            $beans = $this->findAll(table: self::TABLE, conditions: ['parent_id = ?'], params: [$parentId]);
        }

        return array_map(fn($bean) => PostCategory::fromBean($bean), $beans);
    }

   

    // private function createCategoryDTOFromArray(array $row): PostCategoryDTO
    // {
    //     $locale = $this->currentLang ?? self::DEFAULT_LANG;

    //     return new PostCategoryDTO([
    //         'id' => (int) $row['id'],
    //         'title' => (string) ($row['category_title_translation'] ?? ''),
    //         'parent_id' => (int) ($row['parent_id'] ?? 0),
    //         'image' => (string) ($row['image'] ?? ''),
    //         'slug' => (string) ($row['slug'] ?? ''),
    //         'translations' => [
    //             $locale => [
    //                 'slug' => $row['slug'] ?? '',
    //                 'title' => $row['category_title_translation'] ?? '',
    //                 'description' => $row['category_description'] ?? '',
    //                 'seo_title' => $row['category_meta_title'] ?? '',
    //                 'seo_description' => $row['category_meta_description'] ?? '',
    //             ]
    //         ],
    //     ]);
    // }
    private function createCategoryOutputDTOFromArray(array $row): PostCategoryOutputDTO
    {
      $locale = 'ru';
        return new PostCategoryOutputDTO([
            'id' => (int) $row['id'],
            'title' => (string) ($row['category_title_translation'] ?? ''),
            'parent_id' => $row['parent_id'] ?? null,
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
        $dto = $this->createCategoryOutputDTOFromArray($row);
        return PostCategory::fromOutputDTO($dto);
    }


    private function unitePostRawData(string $currentLang, ?int $categoryId = null): array
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

     
        $bindings = [$currentLang];

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





    
    public function getAllCategories(): array
    {
        $beans = $this->findAll(table: self::TABLE);
        return array_map([$this, 'mapBeanToPostCategory'], $beans);
    }

    public function getCategoriesByIds(array $ids): array
    {
        $beans = $this->findByIds(self::TABLE, $ids);
        return array_map([$this, 'mapBeanToPostCategory'], $beans);
    }


    public function getPostCatsByParentId(?int $id = null): array
    {
        if ($id === null) {
            $beans = $this->findAll(table: self::TABLE, conditions: ['parent_id IS NULL']);
        } else {
            $beans = $this->findAll(table: self::TABLE, conditions: ['parent_id = ?'], params: [$id]);
        }

        return array_map([$this, 'mapBeanToPostCategory'], $beans);
    }

    

    public function getParentCategory(PostCategory $childCategrory): ?PostCategory
    {
      $mainCatId =  $childCategrory->getId();
      return $this->getPostCatById($mainCatId);
    }

    

    // public function getSubCats($currentLang): array
    // {
    //     $rows = $this->unitePostRawData($currentLang);

    //     $subCategories = array_filter($rows, function ($row) {
    //         return $row['parent_id'] !== null;
    //     });

    //     return array_map([$this, 'mapArrayToPostCategory'], $subCategories);
    // }


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

  
    public function getAllCategoriesCount (?string $sql = null, array $params = []): int
    {
      return $this->countAll(self::TABLE, $sql, $params);
    }

    
    public function createCategory(PostCategory $cat) 
    {
      return $this->saveCategory($cat);
    }


    public function saveCategory(PostCategory $cat): int
    {
        // сохраняем основную категорию
        $bean = $cat->getId()
            ? $this->loadBean(self::TABLE, $cat->getId())
            : $this->createBean(self::TABLE);

        $bean->title = $cat->getTitle(); // по умолчанию ru
        $bean->parent_id = $cat->getParentId();
        $bean->slug = $cat->getSlug();
        $bean->image = $cat->getImage();
        $bean->seo_title = $cat->getSeoTitle();
        $bean->seo_description = $cat->getSeoDescription();

        $id = (int) $this->saveBean($bean);

        // НЕ удаляем все переводы
        foreach ($cat->getAllTranslations() as $locale => $translation) {
            // ищем перевод для этой локали
            $transBean = $this->findOneBy(
                self::TABLE_TRANSLATION,
                'category_id = ? AND locale = ?',
                [$id, $locale]
            );

            if (!$transBean) {
                // если нет — создаём новый
                $transBean = $this->createBean(self::TABLE_TRANSLATION);
                $transBean->category_id = $id;
                $transBean->locale = $locale;
            }

            // Обновляем только те поля, что реально пришли
            if (array_key_exists('title', $translation)) {
                $transBean->title = $translation['title'];
            }
            if (array_key_exists('description', $translation)) {
                $transBean->description = $translation['description'];
            }
            if (array_key_exists('meta_title', $translation)) {
                $transBean->meta_title = $translation['meta_title'];
            }
            if (array_key_exists('meta_description', $translation)) {
                $transBean->meta_description = $translation['meta_description'];
            }

            $this->saveBean($transBean);
        }

        return $id;
    }

    public function updateCategory(PostCategory $cat): int
    {

      if (!$cat->getId()) {
          return null; // нельзя обновить без ID
      }

      return $this->saveCategory($cat);
    }

    public function deleteCategory(int $id): void
    {
      $bean = $this->loadBean(self::TABLE, $id);
      $this->deleteBean($bean);
    }

}
