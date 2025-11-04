<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Api\Post;

use Vvintage\Routing\RouteData;
use Vvintage\Controllers\Api\BaseApiController;
use Vvintage\Services\Admin\Product\AdminPostService;
use Vvintage\DTO\Product\PostDTO;
use Vvintage\Serializers\PostApiSerializer;
use Vvintage\Services\Admin\Validation\AdminPostValidator;

class PostApiController extends BaseApiController
{
    private AdminPostService $service;
    private PostApiSerializer $serializer;

    public function __construct()
    {
      parent::__construct();
      $this->service = new AdminPostService();
      $this->serializer = new PostApiSerializer();
    }

    public function create(): void
    {
        $this->isAdmin(); // проверка прав

        $data = $this->getRequestData();
        $files = $data['_files'] ?? [];
        unset($data['_files']);


        // Валидация текста
        $validatorText = new AdminPostValidator();
        $validatorTextResult = $validatorText->validate($data);

        // Валидация изображений
        // $validatorImg = new AdminProductImageValidator();
        // $validatorImgResult = $validatorImg->validate($files);

 

        if(!empty($validatorTextResult['errors'])) {
          $this->error($validatorTextResult['errors'], 422);
        }

        // Подготовка изображений
        // $imageService = new AdminProductImageService();
        // $processedImages = $imageService->prepareImages(
        //   $validatorImgResult['data'],
        //   ['full' => [536, 566],'small' => [350, 478]]
        // );

        // Создание статьи
        $postId = $this->service->createPostDraft(
          $validatorTextResult['data'], 
        ); 

        if (!$postId) {
          $this->error(['Не удалось создать статью'], 500);
        }

        $this->success(['id' => $postId], 201);
    }

    // Список всех активных продуктов
    public function getAll(): array 
    {
      // $this->isAdmin(); // проверка прав

      // Получаем продукты из сервиса
      $postsData = $this->service->getPosts(); // <-- метод, который вернёт массив объектов/DTO
      $posts = $this->serializer->toList($postsData);
      // Если есть изображения, категории, можно их добавить через сервис/репозиторий
      // $categories = $this->service->getCategories(); // пример

      // Формируем структуру для фронта
      $data = [
          'posts' => $posts
          // 'categories' => $categories,
      ];

      // Отправляем клиенту JSON
      $this->success($data);
    }

    // Получение одного продукта по ID
    public function getOne(int $id): void
    {
        $post = $this->service->getPostById($id);
        if (!$post) {
            $this->error(['Продукт не найден'], 404);
        }
        $this->success(['post' => $this->serializer->toItem($post)]);
    }

    // Получение продукта по slug
    public function getBySlug(string $slug): void
    {
        $post = $this->service->getPostBySlug($slug);
        if (!$post) {
            $this->error(['Продукт не найден'], 404);
        }
        $this->success(['post' => $this->serializer->toItem($post)]);
    }    
   
}
