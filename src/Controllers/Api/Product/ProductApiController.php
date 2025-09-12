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
        // $this->isAdmin(); // проверка прав
        $productData = $this->getRequestData();
        $text = $productData['_text'];
        $files = $productData['_files']['cover'] ?? [];

        // Валидация текста
        $validatorText = new AdminProductValidator();
        $validatorTextResult = $validatorText->validate($text);

        $structuredImages = $this->getStructuredImages($files);

        // Валидация изображений
        $validatorImg = new AdminProductImageValidator();
        $validatorImgResult = $validatorImg->validate($structuredImages);

        // Объединяем ошибки
        $errors = array_merge( $validatorTextResult['errors'],  $validatorImgResult['errors']);
            //  error_log(print_r($errors, true));
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

    public function edit(int $id): void 
    {
        // $this->isAdmin(); // проверка прав
        $productData = $this->getRequestData();
        $text = $productData['_text'];
        $files = $productData['_files']['cover'] ?? [];
        $existingImages = $text['existing_images'] ?? []; // массив с id и image_order
        // unset($productData);

        error_log(print_r(  $text['existing_images'], true));
    
    
        $structuredImages = $this->getStructuredImages($files);
        // $structuredImages = $this->getStructuredImages($files);

        // unset($productData['existing_images']);


          // error_log(print_r( $files, true));
        // Валидация текста
        $validatorText = new AdminProductValidator();
        $validatorTextResult = $validatorText->validate($text);

        // Валидация новых изображений (только то, что реально загружено через dropzone)
        $validatorImg = new AdminProductImageValidator();
        // $validatorImgResult = $validatorImg->validate($files);
  
        $validatorImgResult = $validatorImg->validate($structuredImages, $existingImages);

        // Объединяем ошибки
        $errors = array_merge($validatorTextResult['errors'], $validatorImgResult['errors']);
        if (!empty($errors)) {
            $this->error($errors, 422);
        }

        // Подготовка новых изображений (только для новых файлов)
        $imageService = new AdminProductImageService();
        $processedNewImages = $imageService->prepareImages(
            $validatorImgResult['data'],
            ['full' => [536, 566], 'small' => [350, 478]]
        );

        // Удаляем существующие изображения, если нужно
        // $imageService->updateExistImages($id, $text['existing_images']);

        // error_log(print_r( $validatorTextResult['data'], true));
        $success = $this->service->updateProduct(
            $id,
            $validatorTextResult['data'],   // текстовые данные
            // $structuredImages,                // какие картинки оставить
            $existingImages,                // существующие изображения с новым порядком
            $processedNewImages             // новые картинки
        );

        if (!$success) {
            $this->error(['Не удалось обновить продукт'], 500);
        }

        $this->success(['id' => $id], 200);
    }

    private function getStructuredImages(array $files): array 
    {
        //  error_log(print_r($files, true));
        $images = [];

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

        // 2. Добавляем существующие изображения из формы
        // foreach ($existing as $i => $existingId) {
        //     // Если нужно, можно добавить реальные имена файлов или url
        //     $images[] = [
        //         'existing_id' => $existingId,
        //         'image_order' => count($images) // порядок после новых
        //     ];
        // }

        return $images;
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
    public function getOne(int $id): void
    {
      // $this->isAdmin(); // проверка прав
      $product = $this->service->getProductById($id);
 
      if (!$product) {
          $this->error(['Продукт не найден'], 404);
      }
      $this->success(['product' => $this->serializer->toItem($product)]);
    }

    // Получение продукта по slug
    public function getBySlug(string $slug): void
    {
         // $this->isAdmin(); // проверка прав
        $product = $this->service->getProductBySlug($slug);
        if (!$product) {
            $this->error(['Продукт не найден'], 404);
        }
        $this->success(['product' => $this->serializer->toItem($product)]);
    }    



   
}
