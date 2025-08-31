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

    public function __construct()
    {
      parent::__construct();
      $this->service = new AdminProductService();

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
   
}
