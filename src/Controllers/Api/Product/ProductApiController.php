<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Api\Product;

use Vvintage\Routing\RouteData;
use Vvintage\Services\Admin\Product\AdminProductService;
use Vvintage\DTO\Product\ProductDTO;
use Vvintage\Serializers\ProductApiSerializer;

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

    // public function load(RouteData $rd): void
    // {
    //     $id = (int)$rd->getUriGetParam();
    //     $product = $this->service->getProductById($id);
    //     if (!$product) { http_response_code(404); echo json_encode(['error'=>'Not found']); return; }

    //     echo json_encode($this->service->toApiArray($product), JSON_UNESCAPED_UNICODE);
    // }

    // public function getAll(): void
    // {
    //   $products = $this->service->getAll();
    //   if (!$products) { http_response_code(404); echo json_encode(['error'=>'Not found']); return; }

    //   echo json_encode($this->service->toApiArray($products), JSON_UNESCAPED_UNICODE);
    // }

    public function create()
    {
      header('Content-Type: application/json');
        $response = [];

        // Проверка текстовых полей
        $requiredFields = ['title' => 'название товара', 
                          'price' => 'стоимость товара', 
                          'url' => 'ссылка на vinted.fr', 
                          'content' => 'описание товара'];

        foreach ($requiredFields as $field => $message) {
            if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
                $response['errors'][] = $message;
            }
        }

        if (!empty($response['errors'])) {
            echo json_encode($response);
            exit();
        }

        // Проверка файлов
        if (!isset($_FILES['cover']) || empty($_FILES['cover']['name'])) {
            $response['errors'][] = 'Добавьте изображения товара';
            echo json_encode($response);
            exit();
        }

      
      // Если передано изображение - уменьшаем, сохраняем, записываем в БД
      if ( isset($_FILES['cover']['name']) && $_FILES['cover']['tmp_name'] !== '') {
        //Если передано изображение - уменьшаем, сохраняем файлы в папку
        $coverImages = saveSliderImg('cover', [350, 478], 12, 'products', [536, 566], [350, 478]);

        // Если в сесси появились ошибки - добавляем их в ответ
        if (!empty($_SESSION['errors'])) {
          foreach($_SESSION['errors'] as $error) {
            $response['errorsImg'][] = [
              'title' => $error['title'],
              'url' => $error['fileName']
            ];
          }

          echo json_encode($response);
          // Очищаем ошибки, чтобы не дублировать
          unset($_SESSION['errors']);
          exit();
        }

        // Если массив изображений пуст - выводим ошибку
        if (empty($coverImages)) {
          $response['errors'][] = 'Добавьте изображения товара';
          echo json_encode($response);
          exit();
        }

        
        // Если новое изображение успешно загружено 
        // $product = R::dispense('products');
        // $product->title = $_POST['title'];
        // $product->content = $_POST['content'];
        // $product->price = $_POST['price'];
        // $product->article = $_POST['article'];
        // $product->category = $_POST['subCat'];
        // $product->brand = $_POST['brand'];
        // $product->stock = 1;
        // $product->url = $_POST['url'];
        // $product->timestamp = time();
        // $product_id = R::store($product);
      
        // Записываем имя файлов в БД
        // foreach ( $coverImages as $value) {
        //   $productImages = R::dispense('productimages');
        //   $productImages->product_id = $product_id;
      
        //   $productImages->filename_full = $value['cover_full'];
        //   $productImages->filename = $value['cover'];
        //   $productImages->filename_small = $value['cover_small'];
        //   $productImages->image_order = $value['order'];
          
        //   R::store( $productImages);
        // }
      
// Посмотреть все POST данные
// 

      
        $response['success'][] = 'Товар успешно добавлен';
        unset($_SESSION['success']);
        $_SESSION['success'][] = ['title' => 'Товар успешно добавлен'];
        echo json_encode($response);
        exit();
      } else {
        $response['errors'][] = 'Добавьте изображения товара';
        echo json_encode($response);
        exit();
      }
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

    public function update(RouteData $rd): void
    {
        $id = (int)$rd->getUriGetParam();
        $data = json_decode(file_get_contents('php://input'), true) ?? [];
        $errors = $this->service->validateApi($data, $id);
        if ($errors) { http_response_code(422); echo json_encode(['errors'=>$errors]); return; }

        $dto = ProductDTO::fromArray($data);
        $ok = $this->service->updateProduct($id, $dto);
        echo json_encode(['success'=>$ok]);
    }

    public function delete(RouteData $rd): void
    {
        $id = (int)$rd->getUriGetParam();
        $ok = $this->service->deleteProduct($id);
        echo json_encode(['success'=>$ok]);
    }

    public function uploadImages(RouteData $rd): void
    {
        $id = (int)$rd->getUriGetParam();
        // ВАЖНО: сюда прилетит POST multipart/form-data → доступны $_FILES
        $result = $this->service->addImages($id, $_FILES['images'] ?? null);
        if (!$result['success']) { http_response_code(422); }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function reorderImages(RouteData $rd): void
    {
        $id = (int)$rd->getUriGetParam();
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
