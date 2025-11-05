<?php
declare(strict_types=1);

namespace Vvintage\Admin\Controllers\Api\Product;

use Vvintage\Routing\RouteData;

use Vvintage\Utils\Api\BaseApiController;
use Vvintage\Admin\Services\Product\AdminProductService;
use Vvintage\Serializers\ProductApiSerializer;
use Vvintage\Admin\Services\Validation\AdminProductValidator;
use Vvintage\Admin\Services\Validation\AdminProductImageValidator;


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
        $productData = $this->getRequestData();
        $text = $productData['_text'];
        $files = $productData['_files']['cover'] ?? [];

        // Проверяем что вернлся массив, а не json строка
        if (!is_array($files)) {
            $files = [];
        }

        // // Валидация текста
        $validatorText = new AdminProductValidator();
        $validatorTextResult = $validatorText->validate($text);

        $structuredImages = $this->getStructuredImages($files);

        // // Валидация изображений
        $validatorImg = new AdminProductImageValidator();
        $validatorImgResult = $validatorImg->validate($structuredImages);

        // // Объединяем ошибки
        $errors = array_merge( $validatorTextResult['errors'],  $validatorImgResult['errors']);
          error_log(print_r( $errors, true));
        if(!empty($errors)) {
          $this->error($errors, 422);
        }


        // Создание продукта
        $productId = $this->service->createProductDraft(
          $validatorTextResult['data'], 
          $validatorImgResult['data'],  
           $structuredImages 
        ); 

        if (!$productId) {
          $this->error(['Не удалось создать продукт'], 500);
        }

        $this->success(['id' => $productId], 201);
    }

    public function edit(int $id): void 
    {
        $this->isAdmin(); // проверка прав
        $productData = $this->getRequestData();
        
        $text = $productData['_text'];
        $files = $productData['_files']['cover'] ?? [];
        $fileOrders = $text['cover_order'] ?? []; //  порядок новых изображений с фронта
        $existingImages = $text['existing_images'] ?? []; // массив с id и image_order

        try {
     

          if ($files) {
            // Структурируем новые изображения и добавляем порядок
            $structuredImages = $this->getStructuredImages($files);

            foreach ($structuredImages as $i => &$img) {
                $img['image_order'] = $fileOrders[$i] ?? 0; // порядок с фронта
            }
            unset($img);

            // Валидация новых изображений (только то, что реально загружено через dropzone)
            $validatorImg = new AdminProductImageValidator();
            $validatorImgResult = $validatorImg->validate($structuredImages, $existingImages);
          }
        
          // Валидация текста
          $validatorText = new AdminProductValidator();
          $validatorTextResult = $validatorText->validate($text);

      

          // Объединяем ошибки
          // $errors = array_merge($validatorTextResult['errors'], $validatorImgResult['errors']);
          // if (!empty($errors)) {
          //     $this->error($errors, 422);
          // }


        $success = $this->service->updateProduct(
            $id,
            $validatorTextResult['data'],   // текстовые данные
            $existingImages,                // существующие изображения с новым порядком
            $validatorImgResult['data'] ?? []         // новые картинки
        );
      } catch (\Exception $e) {
          $this->error($e->getMessage(), 500);
      }

        if (!$success) {
            $this->error(['Не удалось обновить продукт'], 500);
        }

        $this->success(['id' => $id], 200);
    }

    private function getStructuredImages(array $files): array 
    {
        if(!$files) return [];
        $images = [];

        if (!isset($files['name']) || !is_array($files['name'])) {
            return $images; 
        }

        // 1. Обрабатываем новые загруженные файлы
        foreach ($files['name'] ?? [] as $i => $name) {
            if ($files['error'][$i] === UPLOAD_ERR_NO_FILE) continue; // пропускаем пустые
            $images[] = [
                'file_name'   => $name,
                'tmp_name'    => $files['tmp_name'][$i],
                'type'        => $files['type'][$i],
                'size'        => $files['size'][$i],
                'error'       => $files['error'][$i],
                'image_order' => $i
            ];
        }

        

        return $images;
    }


    // Список всех активных продуктов
    public function getAll(): array 
    {
      $this->isAdmin(); // проверка прав

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
    public function getOne(int $id): void
    {
      $this->isAdmin(); // проверка прав
      $product = $this->service->getProductById($id);
 
      if (!$product) {
          $this->error(['Продукт не найден'], 404);
      }
      $this->success(['product' => $this->serializer->toItem($product)]);
    }

    // Получение продукта по slug
    public function getBySlug(string $slug): void
    {
         $this->isAdmin(); // проверка прав
        $product = $this->service->getProductBySlug($slug);
        if (!$product) {
            $this->error(['Продукт не найден'], 404);
        }
        $this->success(['product' => $this->serializer->toItem($product)]);
    }    



   
}
