<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Api\Product;

use Vvintage\Routing\RouteData;
use Vvintage\Controllers\Api\BaseApiController;
use Vvintage\Services\Admin\Product\AdminProductService;
use Vvintage\Services\Admin\Product\AdminProductImageService;
use Vvintage\DTO\Product\ProductDTO;
use Vvintage\Serializers\ProductApiSerializer;
use Vvintage\Services\Admin\Validation\AdminProductValidator;
use Vvintage\Services\Admin\Validation\AdminProductImageValidator;


class ProductApiController extends BaseApiController
{
    private AdminProductService $service;
    private ProductApiSerializer $serializer;

    public function __construct()
    {
      parent::__construct();
      $this->service = new AdminProductService();
      $this->serializer = new ProductApiSerializer();
    }

    public function create(): void
    {
        $this->isAdmin(); // проверка прав

        $data = $this->getRequestData();
        $files = $data['_files'] ?? [];
        unset($data['_files']);


        // Валидация текста
        $validatorText = new AdminProductValidator();
        $validatorTextResult = $validatorText->validate($data);

        // Валидация изображений
        $validatorImg = new AdminProductImageValidator();
        $validatorImgResult = $validatorImg->validate($files);

        // Объединяем ошибки
        $errors = array_merge( $validatorTextResult['errors'],  $validatorImgResult['errors']);
        if(!empty($errors)) {
          $this->error($errors, 422);
        }

        // Подготовка изображений
        $imageService = new AdminProductImageService();
        $processedImages = $imageService->prepareImages(
          $validatorImgResult['data'],
          ['full' => [536, 566],'small' => [350, 478]]
        );

        // Создание продукта
        $productId = $this->service->createProductDraft(
          $validatorTextResult['data'], 
          $validatorImgResult['data'],  
          $processedImages
        ); 

        if (!$productId) {
          $this->error(['Не удалось создать продукт'], 500);
        }

        $this->success(['id' => $productId], 201);
    }

    // Список всех активных продуктов
    public function getAll(): array 
    {
      // $this->isAdmin(); // проверка прав

      // Получаем продукты из сервиса
      $productsData = $this->service->getActiveProducts(); // <-- метод, который вернёт массив объектов/DTO
      $products = $this->serializer->toList($productsData);
      // Если есть изображения, категории, можно их добавить через сервис/репозиторий
      // $categories = $this->service->getCategories(); // пример

      // Формируем структуру для фронта
      $data = [
          'products' => $products
          // 'categories' => $categories,
      ];

      // Отправляем клиенту JSON
      $this->success($data);
    }

    // Получение одного продукта по ID
    public function getOne(RouteData $routeData): void
    {
      $id = (int) $routeData->uriGetParams[0];
      $product = $this->service->getProductById($id);
 
      if (!$product) {
          $this->error(['Продукт не найден'], 404);
      }
      $this->success(['product' => $this->serializer->toItem($product)]);
    }

    // Получение продукта по slug
    public function getBySlug(string $slug): void
    {
        $product = $this->service->getProductBySlug($slug);
        if (!$product) {
            $this->error(['Продукт не найден'], 404);
        }
        $this->success(['product' => $this->serializer->toItem($product)]);
    }    
   
}
