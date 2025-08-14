<?php
declare(strict_types=1);

namespace Vvintage\Controllers;

// use Vvintage\Contracts\Category\CategoryRepositoryInterfave;
// use Vvintage\Repositories\Category\CategoryRepository;
use Vvintage\Models\Category\Category;
// use Vvintage\DTO\Category\CategoryDTO;
use Vvintage\Services\Category\CategoryService;

final class CategoryController
{
    public function __construct()
    {
        $this->categoryService = new CategoryService();
    }

    /**
     * Получить список категорий с переводами в нужной локали
     *
     * @param string $locale
     * @return array
     */
    public function index(string $locale = 'ru'): array
    {
        $rawCategories = $this->categoryService->getAllCategories(); // массив из БД
        // $rawCategories = $this->categoryRepository->getAllCategories(); // массив из БД

        $categories = [];

        foreach ($rawCategories as $rawCategory) {
            $dto = new CategoryDTO($rawCategory);
            $category = Category::fromDTO($dto);
            $category->setCurrentLocale($locale);

            $categories[] = [
                'id' => $category->getId(),
                'title' => $category->getTitle(),
                'image' => $category->getImage(),
                'parent_id' => $category->getParentId(),
                'seo_title' => $category->getSeoTitle(),
                'seo_description' => $category->getSeoDescription(),
            ];
        }

        return $categories;
    }

      /**
     * Получить одну категорию по ID с переводом в нужной локали
     */
    public function show(int $id, string $locale = 'ru'): ?array
    {
        $category = $this->categoryRepository->getCategoryById($id);

        if (!$category) {
            return null; // или можно бросить исключение
        }

        $category->setCurrentLocale($locale);

        return [
            'id' => $category->getId(),
            'title' => $category->getTitle(),
            'image' => $category->getImage(),
            'parent_id' => $category->getParentId(),
            'seo_title' => $category->getSeoTitle(),
            'seo_description' => $category->getSeoDescription(),
        ];
    }

    /**
     * Создать новую категорию
     * 
     * @param array $data — данные категории, включая переводы
     * Пример $data:
     * [
     *   'title' => 'Категория по умолчанию',
     *   'parent_id' => 0,
     *   'image' => 'image.jpg',
     *   'translations' => [
     *       'ru' => ['title' => 'Категория', 'seo_title' => 'SEO заголовок', ...],
     *       'en' => ['title' => 'Category', 'seo_title' => 'SEO title', ...],
     *   ],
     *   'seo_title' => 'SEO заголовок по умолчанию',
     *   'seo_description' => 'SEO описание по умолчанию',
     * ]
     * 
     * @return int — ID созданной категории
     */
    public function create(array $data): int
    {
        $category = Category::fromArray($data);

        return $this->categoryRepository->saveCategory($category);
    }

    /**
     * Обновить существующую категорию
     * 
     * @param int $id — ID категории для обновления
     * @param array $data — новые данные категории, включая переводы
     * 
     * @return bool — true, если успешно, false — если категория не найдена
     */
    public function update(int $id, array $data): bool
    {
        $existingCategory = $this->categoryRepository->getCategoryById($id);

        if (!$existingCategory) {
            return false;
        }

        // Обновляем свойства существующего объекта Category
        // Можно сделать через fromArray, но с сохранением ID и locale
        $updatedData = array_merge([
            'id' => $id,
            'locale' => $existingCategory->getCurrentLocale(),
        ], $data);

        $updatedCategory = Category::fromArray($updatedData);

        $this->categoryRepository->saveCategory($updatedCategory);

        return true;
    }
}

// $controller = new CategoryController(new CategoryRepository());

// $cat = $controller->show(2, 'en');
// print_r($cat);



// $repo = new CategoryRepository($db); // $db — соединение с базой
// $controller = new CategoryController($repo);

// $categoriesEn = $controller->index('en');
// $categoriesRu = $controller->index('ru');

// print_r($categoriesEn); // выведет категории на английском
