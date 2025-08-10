<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Admin;

use Vvintage\Routing\RouteData;

/** Контракты */
use Vvintage\Contracts\Brand\BrandRepositoryInterface;

/** Контроллеры */
use Vvintage\Controllers\Admin\BaseAdminController;

/** Репозитории */
use Vvintage\Repositories\Category\CategoryRepository;
use Vvintage\Repositories\Brand\BrandRepository;
use Vvintage\Repositories\Product\ProductRepository;

/** Сервисы */
use Vvintage\Services\Product\ProductImageService;



class AdminProductController extends BaseAdminController
{
  private ProductRepository $productRepository;
  private CategoryRepository $categoryRepository;
  private BrandRepository $brandRepository;

  public function __construct()
  {
    parent::__construct();
    $this->productRepository = new ProductRepository();
    $this->categoryRepository = new CategoryRepository( 'ru');
    $this->brandRepository = new BrandRepository('ru');
  }

  public function all (RouteData $routeData)
  {
    $this->isAdmin();
    $this->renderAllProducts($routeData);
  }

  public function add (RouteData $routeData)
  {
    $this->isAdmin();
    $this->renderAddProduct($routeData);
  }

  public function edit(RouteData $routeData)
  {
    $this->isAdmin();

    // Получаем продукт 
    $productId = $_GET['id'];
    $product = $this->productRepository->getProductById((int) $productId);

    // Получаем главные категориии, подкатегории и бренды
    $mainCats = $this->categoryRepository->getMainCats();
    $subCats = $this->categoryRepository->getSubCats();
    $brands = $this->brandRepository->getAllBrands();

    // Загружаем объект категории
    $selectedSubCat = $product->getCategory();

    // Главный раздел
    $selectedMaiCat = $this->categoryRepository->getParentCategory($selectedSubCat);

    if( isset($_POST['submit'])) {
      // Проверка токена
      if (!check_csrf($_POST['csrf'] ?? '')) {
        $_SESSION['errors'][] = ['error', 'Неверный токен безопасности'];
      }

      // Проверка на заполненность названия
      if( trim($_POST['title']) == '' ) {
        $_SESSION['errors'][] = ['title' => 'Введите название товара'];
      } 

      // Проверка на заполненность содержимого
      if( trim($_POST['price']) == '' ) {
        $_SESSION['errors'][] = ['title' => 'Введите стоимость товара'];
      } 

      // Проверка на заполненность содержимого
      if( trim($_POST['content']) == '' ) {
        $_SESSION['errors'][] = ['title' => 'Введите описание товара'];
      } 

      // Если нет ошибок
      if ( empty($_SESSION['errors'])) {
        $product = R::load('products', $_GET['id']);
        $product->title = $_POST['title'];
        $product->cat = $_POST['subCat'];
        $product->brand = $_POST['brand'];
        $product->price = $_POST['price'];
        $product->content = $_POST['content'];
        $product->editTime = time();

        // Если передано изображение - уменьшаем, сохраняем, записываем в БД
        if( isset($_FILES['cover']['name']) && $_FILES['cover']['tmp_name'] !== '') {
          //Если передано изображение - уменьшаем, сохраняем файлы в папку, получаем название файлов изображений
          $coverFileName = saveUploadedImgNoCrop('cover', [600, 300], 12, 'products', [540, 380], [290, 230]);

          // Если новое изображение успешно загружено 
          if ($coverFileName) {
            $coverFolderLocation = ROOT . 'usercontent/products/';
            // Если есть старое изображение - удаляем 
            if (file_exists($coverFolderLocation . $product->cover) && !empty($product->cover)) {
              unlink($coverFolderLocation . $product->cover);
            }

            // Если есть старое маленькое изображение - удаляем 
            if (file_exists($coverFolderLocation . $product->coverSmall) && !empty($product->coverSmall)) {
              unlink($coverFolderLocation . $product->coverSmall);
            }
              // Записываем имя файлов в БД
            $product->cover = $coverFileName[0];
            $product->coverSmall = $coverFileName[1];
          }
        }

        // Удаление обложки
        if ( isset($_POST['delete-cover']) && $_POST['delete-cover'] == 'on') {
          $coverFolderLocation = ROOT . 'usercontent/products/';

          // Если есть старое изображение - удаляем 
          if (file_exists($coverFolderLocation . $product->cover) && !empty($product->cover)) {
            unlink($coverFolderLocation . $product->cover);
          }

          // Если есть старое маленькое изображение - удаляем 
          if (file_exists($coverFolderLocation . $product->coverSmall) && !empty($product->coverSmall)) {
            unlink($coverFolderLocation . $product->coverSmall);
          }

          // Удалить записи файла в БД
          $product->cover = NULL;
          $product->coverSmall = NULL;
        }

        R::store($product);

        if ( empty($_SESSION['errors'])) {
          $_SESSION['success'][] = ['title' => 'Товар успешно обновлен.'];
        }
      }
    }

    // Получаем продукт по id
    $product = R::load('products', $_GET['id']);

    // Центральный шаблон для модуля
    ob_start();
    include ROOT . "admin/templates/shop/edit.tpl";
    $content = ob_get_contents();
    ob_end_clean();

    //Шаблон страницы
    include ROOT . "admin/templates/template.tpl";

  }

  
  private function renderAllProducts(RouteData $routeData): void
  {
    // Название страницы
    $pageTitle = 'Все товары';

    $productsPerPage = 9;

    // Устанавливаем пагинацию
    $pagination = pagination($productsPerPage, 'products');
    $products = $this->productRepository->getAllProducts($pagination);
    $total = $this->productRepository->getAllProductsCount();

    // Получаем изображения товаров
    $imageService = new ProductImageService();

    $imagesByProductId = [];

    foreach ($products as $product) {
        $imagesMainAndOthers = $imageService->splitImages($product->getImages());
        $imagesByProductId[$product->getId()] = $imagesMainAndOthers;
    }

    // Формируем единую модель для передачи в шаблон
    $productViewModel = [
        'products' => $products,
        'total' => $total,
        'imagesByProductId' => $imagesByProductId
    ];
        

    $this->renderLayout('shop/all',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
      'productViewModel' => $productViewModel,
      'pagination' => $pagination
    ]);
  }

  private function renderAddProduct(RouteData $routeData): void
  {
    // Название страницы
    $pageTitle = "Добавить новый товар";
    // $pageClass = "admin-page";

    $this->renderLayout('shop/new',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
    ]);
  }

  private function renderEditProduct(RouteData $routeData): void
  {
    // Название страницы
    $pageTitle = "Редактирование товара";
    // $pageClass = "admin-page";

    $this->renderLayout('shop/edit',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
    ]);
  }
}