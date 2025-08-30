<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Admin\Product;

use Vvintage\Routing\RouteData;
use Vvintage\Contracts\Brand\BrandRepositoryInterface;
use Vvintage\Controllers\Admin\BaseAdminController;
use Vvintage\Services\Admin\Product\AdminProductService;
use Vvintage\Services\Admin\Brand\AdminBrandService;


class AdminProductController extends BaseAdminController
{
  private AdminProductService $adminProductService;
  // private AdminBrandService $brandService;

  public function __construct()
  {
    parent::__construct();
    $this->adminProductService = new AdminProductService();
    // $this->brandService = new AdminBrandService();
  }

  public function all (RouteData $routeData)
  {
    $this->isAdmin();
    $this->setRouteData($routeData);
    $this->adminProductService->handleStatusAction($_POST);
    $this->renderAllProducts($routeData);
  }

  public function new(RouteData $routeData)
  {
    $this->isAdmin();
    $this->setRouteData($routeData);
    $this->renderAddProduct($routeData);
  }

  public function edit(RouteData $routeData)
  {
    $this->isAdmin();
    $this->setRouteData($routeData);
    $this->adminProductService->handleStatusAction($_POST);
    $this->renderEditProduct();
  }

  public function delete (RouteData $routeData)
  {
    $this->isAdmin();
    $this->setRouteData($routeData);
    $this->renderDelete();
  }

  
  private function renderAllProducts(): void
  {
    // Название страницы
    $pageTitle = 'Все товары';

    $productsPerPage = 9;

    // Устанавливаем пагинацию
    $pagination = pagination($productsPerPage, 'products');
    $products = $this->adminProductService->getAll($pagination);
    $total = $this->adminProductService->countProducts();
    $actions = $this->adminProductService->getActions();

    $imagesByProductId = [];

    foreach ($products as $product) {
        $imagesMainAndOthers = $this->adminProductService->getProductImages($product);
        $imagesByProductId[$product->getId()] = $imagesMainAndOthers;
    }

    // Формируем единую модель для передачи в шаблон
    $productViewModel = [
        'products' => $products,
        'total' => $total,
        'imagesByProductId' => $imagesByProductId,
        'actions'=> $actions
    ];
        

    $this->renderLayout('shop/all',  [
      'pageTitle' => $pageTitle,
      'routeData' => $this->routeData,
      'productViewModel' => $productViewModel,
      'pagination' => $pagination,
      'flash' => $this->flash
    ]);
  }

  private function renderAddProduct(): void
  {
    // Название страницы
    $pageTitle = "Добавить новый товар";
    $statusList = $this->adminProductService->getStatusList();
    // $pageClass = "admin-page";


    $this->renderLayout('shop/new',  [
      'pageTitle' => $pageTitle,
      'routeData' => $this->routeData,
      'statusList' => $statusList,
      'flash' => $this->flash,
      'product' => null,
      'languages' => $this->languages,
      'currentLang' => $this->currentLang,
    ]);
  }

  private function renderEditProduct(): void
  {
    // Название страницы
    $pageTitle = "Редактирование товара";
    // $pageClass = "admin-page";

    // Получаем продукт по Id 
    $id = $this->routeData->uriGet ? (int) $this->routeData->uriGet : null;

    if (!$id) $this->redirect('admin/shop');

    $product = $this->adminProductService->getProductById($id);
    $statusList = $this->adminProductService->getStatusList();


    // if( isset($_POST['submit'])) {
    //   // Проверка токена
    //   if (!check_csrf($_POST['csrf'] ?? '')) {
    //     $_SESSION['errors'][] = ['error', 'Неверный токен безопасности'];
    //   }

    //   // Проверка на заполненность названия
    //   if( trim($_POST['title']) == '' ) {
    //     $_SESSION['errors'][] = ['title' => 'Введите название товара'];
    //   } 

    //   // Проверка на заполненность содержимого
    //   if( trim($_POST['price']) == '' ) {
    //     $_SESSION['errors'][] = ['title' => 'Введите стоимость товара'];
    //   } 

    //   // Проверка на заполненность содержимого
    //   if( trim($_POST['content']) == '' ) {
    //     $_SESSION['errors'][] = ['title' => 'Введите описание товара'];
    //   } 

    //   // Если нет ошибок
    //   if ( empty($_SESSION['errors'])) {
    //     $product = R::load('products', $_GET['id']);
    //     $product->title = $_POST['title'];
    //     $product->cat = $_POST['subCat'];
    //     $product->brand = $_POST['brand'];
    //     $product->price = $_POST['price'];
    //     $product->content = $_POST['content'];
    //     $product->editTime = time();

    //     // Если передано изображение - уменьшаем, сохраняем, записываем в БД
    //     if( isset($_FILES['cover']['name']) && $_FILES['cover']['tmp_name'] !== '') {
    //       //Если передано изображение - уменьшаем, сохраняем файлы в папку, получаем название файлов изображений
    //       $coverFileName = saveUploadedImgNoCrop('cover', [600, 300], 12, 'products', [540, 380], [290, 230]);

    //       // Если новое изображение успешно загружено 
    //       if ($coverFileName) {
    //         $coverFolderLocation = ROOT . 'usercontent/products/';
    //         // Если есть старое изображение - удаляем 
    //         if (file_exists($coverFolderLocation . $product->cover) && !empty($product->cover)) {
    //           unlink($coverFolderLocation . $product->cover);
    //         }

    //         // Если есть старое маленькое изображение - удаляем 
    //         if (file_exists($coverFolderLocation . $product->coverSmall) && !empty($product->coverSmall)) {
    //           unlink($coverFolderLocation . $product->coverSmall);
    //         }
    //           // Записываем имя файлов в БД
    //         $product->cover = $coverFileName[0];
    //         $product->coverSmall = $coverFileName[1];
    //       }
    //     }

    //     // Удаление обложки
    //     if ( isset($_POST['delete-cover']) && $_POST['delete-cover'] == 'on') {
    //       $coverFolderLocation = ROOT . 'usercontent/products/';

    //       // Если есть старое изображение - удаляем 
    //       if (file_exists($coverFolderLocation . $product->cover) && !empty($product->cover)) {
    //         unlink($coverFolderLocation . $product->cover);
    //       }

    //       // Если есть старое маленькое изображение - удаляем 
    //       if (file_exists($coverFolderLocation . $product->coverSmall) && !empty($product->coverSmall)) {
    //         unlink($coverFolderLocation . $product->coverSmall);
    //       }

    //       // Удалить записи файла в БД
    //       $product->cover = NULL;
    //       $product->coverSmall = NULL;
    //     }

    //     R::store($product);

    //     if ( empty($_SESSION['errors'])) {
    //       $_SESSION['success'][] = ['title' => 'Товар успешно обновлен.'];
    //     }
    //   }
    // }


    $this->renderLayout('shop/edit',  [
      'product' => $product,
      'pageTitle' => $pageTitle,
      'routeData' => $this->routeData,
      'statusList' => $statusList,
      'flash' => $this->flash
    ]);
  }

  private function renderDelete(): void
  {
    
    // Название страницы
    $pageTitle = 'Удалить категорию блога';

    $id = $this->routeData->uriGet ? (int) $this->routeData->uriGet : null;

    if (!$id) $this->redirect('admin/category-blog');

    $category = $this->service->getCategoryById($id);


    // Если нет ошибок
    if (isset($_POST['submit'])) {
      $csrfToken = $_POST['csrf'] ?? '';

      if (!$csrfToken) {
        $this->flash->pushSuccess('Неверный токен безопасности');
        $this->redirect('admin/category-blog');
      }

      $this->service->deleteCategory($id);

      $this->flash->pushSuccess('Категория успешно удалена.');
      $this->redirect('admin/category-blog');
    }


        
    $this->renderLayout('post-categories/delete',  [
      'pageTitle' => $pageTitle,
      'routeData' => $this->routeData,
      'category' => $category,
      'flash' => $this->flash
    ]);

  }

}