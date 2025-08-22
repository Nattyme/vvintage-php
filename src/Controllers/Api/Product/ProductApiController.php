<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Api\Product;

use Vvintage\Routing\RouteData;
use Vvintage\Controllers\Admin\BaseAdminController;
use Vvintage\Services\Admin\Product\AdminProductService;
use Vvintage\DTO\Product\ProductDTO;
use Vvintage\Serializers\ProductApiSerializer;
use Vvintage\Services\Admin\Validation\AdminProductValidator;
use Vvintage\Services\Admin\Validation\AdminProductImageValidator;

require_once ROOT . "libs/resize-and-crop.php";
require_once ROOT . "libs/functions.php";


class ProductApiController extends BaseAdminController
{
    private AdminProductService $service;

    public function __construct()
    {
      parent::__construct();
      $this->service = new AdminProductService();
    }

    public function create()
    {
        $this->isAdmin();

        header('Content-Type: application/json; charset=utf-8');

        $response = [
            'success' => false,
            'errors' => [],
            'data' => []
        ];

        // Принимаем данные
        $data = $_POST;
        $files = $_FILES ?? [];


        // Валидация текста
        $validatorText = new AdminProductValidator();
        $validatorTextResult = $validatorText->validate($data);
        $data = array_merge( $data,  $validatorTextResult['data']);

        // Валидация изображений
        $validatorImg = new AdminProductImageValidator();
        $validatorImgResult = $validatorImg->validate($files);
  

        // Объединяем ошибки
        $response['errors']  =  array_merge($validatorTextResult['errors'],  $validatorImgResult['errors']);
        

        // Если есть ошибки, сразу возвращаем JSON
        if (!empty($response['errors'])) {
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
            exit();
        }


       // Если ошибок нет — создаём dto товара и сохраняем через сервис
        $productId = $this->service->createProductDraft($data,  $validatorImgResult['data']); 
        $response['success'] = true;

        echo json_encode($response, JSON_UNESCAPED_UNICODE);

            
        if ($productId) {
            $response['success'] = true;
            $response['data'] = ['id' => $productId];
        } else {
            $response['errors'][] = 'Не удалось создать продукт';
        }

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }
   


    // public function uploadImages(RouteData $routeData): void
    // {
    //     $id = (int)$routeData->getUriGetParam();
    //     // ВАЖНО: сюда прилетит POST multipart/form-data → доступны $_FILES
    //     $result = $this->service->addImages($id, $_FILES['images'] ?? null);
    //     if (!$result['success']) { http_response_code(422); }
    //     echo json_encode($result, JSON_UNESCAPED_UNICODE);
    // }

    // public function reorderImages(RouteData $routeData): void
    // {
    //     $id = (int)$routeData->getUriGetParam();
    //     $data = json_decode(file_get_contents('php://input'), true) ?? [];
    //     $ok = $this->service->reorderImages($id, $data['order'] ?? []);
    //     echo json_encode(['success'=>$ok]);
    // }


    // public function load(RouteData $rd): void
    // {
    //     $id = (int)$rd->getUriGetParam();
    //     $product = $this->service->getProductById($id);

    //     if (!$product) {
    //         http_response_code(404);
    //         echo json_encode(['error'=>'Not found']);
    //         return;
    //     }

    //     echo json_encode(ProductApiSerializer::toArray($product), JSON_UNESCAPED_UNICODE);
    // }

    // public function getAll(): void
    // {
    //     $products = $this->service->getAll();

    //     if (!$products) {
    //         http_response_code(404);
    //         echo json_encode(['error'=>'Not found']);
    //         return;
    //     }

    //     echo json_encode(ProductApiSerializer::toList($products), JSON_UNESCAPED_UNICODE);
    // }

}
