<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Api\Product;

use Vvintage\Routing\RouteData;
use Vvintage\Services\Admin\Product\AdminProductService;
use Vvintage\DTO\Product\ProductDTO;
use Vvintage\Serializers\ProductApiSerializer;
use Vvintage\Services\Admin\Validation\AdminProductValidator;
use Vvintage\Services\Admin\Validation\AdminProductImageValidator;

require_once ROOT . "libs/resize-and-crop.php";
require_once ROOT . "libs/functions.php";


class ProductApiController
{
    private AdminProductService $service;

    public function __construct()
    {
        $this->service = new AdminProductService();
        header('Content-Type: application/json; charset=utf-8');
    }



    // public function create()
    // {
    //     header('Content-Type: application/json; charset=utf-8');

    //     // Проверка текстовых полей через валидатор
    //     $response = AdminProductValidator::validate($_POST);

    //     if (!empty($response['errors'])) {
    //         echo json_encode($response, JSON_UNESCAPED_UNICODE);
    //         exit();
    //     }

    //     $files = $_FILES['cover'] ?? [];
    //     $orders = $_POST['order'] ?? [];


    //     // Проверка файлов
    //     $fileResponse = AdminProductImageValidator::validate($files ?? []);

    //     if (!empty($fileResponse['errors'])) {
    //         echo json_encode($fileResponse, JSON_UNESCAPED_UNICODE);
    //         exit();
    //     }

    //     // Если передано изображение, сохраняем его
    //     if (isset($_FILES['cover']['name']) && $_FILES['cover']['tmp_name'] !== '') {
    //         $coverImages = saveSliderImg('cover', [350, 478], 12, 'products', [536, 566], [350, 478]);

    //         if (empty($coverImages)) {
    //             echo json_encode(['errors' => ['Добавьте изображения товара']], JSON_UNESCAPED_UNICODE);
    //             exit();
    //         }

    //         // Если были ошибки при сохранении изображения в сессию
    //         if (!empty($_SESSION['errors'])) {
    //             $imgErrors = [];
    //             foreach ($_SESSION['errors'] as $error) {
    //                 $imgErrors[] = [
    //                     'title' => $error['title'],
    //                     'url' => $error['fileName']
    //                 ];
    //             }
    //             unset($_SESSION['errors']);
    //             echo json_encode(['errorsImg' => $imgErrors], JSON_UNESCAPED_UNICODE);
    //             exit();
    //         }

    //         // Создаем DTO и сохраняем через сервис
    //         $productDTO = new ProductDTO($_POST);
    //         $id = $this->service->createProduct($productDTO);

    //         echo json_encode(['success' => ['Товар успешно добавлен'], 'id' => $id], JSON_UNESCAPED_UNICODE);
    //         exit();
    //     }

    //     // Если изображение не передано
    //     echo json_encode(['success' => ['все ок']], JSON_UNESCAPED_UNICODE);
    //     echo json_encode(['errors' => ['Добавьте изображения товара']], JSON_UNESCAPED_UNICODE);
    //     exit();
    // }

    public function create()
    {
        // $response = ['errors' => [], 'success' => []];
        $response = [
            'success' => false,
            'errors' => [],
            'data' => []
        ];


        // Сначала проверяем текстовые поля
        $validatorText = new AdminProductValidator();
        $validatorImg = new AdminProductImageValidator();

        $validatorTextResult = $validatorText->validate($_POST);
        $_POST = array_merge( $_POST,  $validatorTextResult['data']);
        $validatorImgResult = $validatorImg->validate($_FILES);
  

        // Совмещаем ошибка валидатора текста и изображений 
        $response['errors']  =  array_merge($validatorTextResult['errors'],  $validatorImgResult['errors']);
        

  
        // Если есть ошибки, сразу возвращаем JSON
        if (!empty($response['errors'])) {
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
            exit();
        }


       // Если ошибок нет — создаём товар
        $productId = $this->service->createProductDraft($_POST,  $validatorImgResult['data']); 
        $response['success'] = true;
        // $response['data'] = ['id' => $productId];

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
        // Сохраняем изображения
        // $coverImages = [];
        // if (isset($_FILES['cover']['name']) && !empty($_FILES['cover']['tmp_name'][0])) {
        //     $coverImages = saveSliderImg('cover', [350, 478], 12, 'products', [536, 566], [350, 478]);

        //     if (empty($coverImages)) {
        //         $response['errors']['cover'][] = 'Не удалось сохранить изображения';
        //         echo json_encode($response, JSON_UNESCAPED_UNICODE);
        //         exit();
        //     }
        // } else {
        //     $response['errors']['cover'][] = 'Добавьте изображения товара';
        //     echo json_encode($response, JSON_UNESCAPED_UNICODE);
        //     exit();
        // }

        // Создаем DTO и сохраняем товар
        $productDTO = new ProductDTO($_POST);
        $id = $this->service->createProductDraft($productDTO);
        $response['success'][] = 'Товар успешно добавлен';
        $response['id'] = $id;
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }
   



    public function store(): void
    {
        $data = json_decode(file_get_contents('php://input'), true) ?? [];
        $errors = $this->service->validateApi($data);
        if ($errors) { http_response_code(422); echo json_encode(['errors'=>$errors]); return; }

        $dto = ProductDTO::fromArray($data);
        $id = $this->service->createProduct($dto);
        echo json_encode(['success'=>true, 'id'=>$id]);
    }

    public function update(RouteData $routeData): void
    {
        $id = (int)$routeData->getUriGetParam();
        $data = json_decode(file_get_contents('php://input'), true) ?? [];
        $errors = $this->service->validateApi($data, $id);
        if ($errors) { http_response_code(422); echo json_encode(['errors'=>$errors]); return; }

        $dto = ProductDTO::fromArray($data);
        $ok = $this->service->updateProduct($id, $dto);
        echo json_encode(['success'=>$ok]);
    }

    public function delete(RouteData $routeData): void
    {
        $id = (int)$routeData->getUriGetParam();
        $ok = $this->service->deleteProduct($id);
        echo json_encode(['success'=>$ok]);
    }

    public function uploadImages(RouteData $routeData): void
    {
        $id = (int)$routeData->getUriGetParam();
        // ВАЖНО: сюда прилетит POST multipart/form-data → доступны $_FILES
        $result = $this->service->addImages($id, $_FILES['images'] ?? null);
        if (!$result['success']) { http_response_code(422); }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function reorderImages(RouteData $routeData): void
    {
        $id = (int)$routeData->getUriGetParam();
        $data = json_decode(file_get_contents('php://input'), true) ?? [];
        $ok = $this->service->reorderImages($id, $data['order'] ?? []);
        echo json_encode(['success'=>$ok]);
    }


    public function load(RouteData $rd): void
    {
        $id = (int)$rd->getUriGetParam();
        $product = $this->service->getProductById($id);

        if (!$product) {
            http_response_code(404);
            echo json_encode(['error'=>'Not found']);
            return;
        }

        echo json_encode(ProductApiSerializer::toArray($product), JSON_UNESCAPED_UNICODE);
    }

    public function getAll(): void
    {
        $products = $this->service->getAll();

        if (!$products) {
            http_response_code(404);
            echo json_encode(['error'=>'Not found']);
            return;
        }

        echo json_encode(ProductApiSerializer::toList($products), JSON_UNESCAPED_UNICODE);
    }

}
