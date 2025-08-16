<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Admin\Post;

use Vvintage\Routing\RouteData;
use Vvintage\Services\Page\Breadcrumbs;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Admin\Post\AdminPostService;

/** Контракты */
use Vvintage\Contracts\Post\PostRepositoryInterface;
use Vvintage\Contracts\PostCategory\PostCategoryRepositoryInterface;

/** Контроллеры */
use Vvintage\Controllers\Admin\BaseAdminController;

class AdminPostController extends BaseAdminController
{
  private AdminPostService $adminPostService;
  private Breadcrumbs $breadcrumbs;
  private FlashMessage $flash;

  public function __construct(FlashMessage $flash, Breadcrumbs $breadcrumbs)
  {
    parent::__construct();
    $this->adminPostService = new AdminPostService($this->languages, $this->currentLang);
    $this->breadcrumbs = $breadcrumbs;
    $this->flash = $flash;
  }

  public function all (RouteData $routeData)
  {
    $this->isAdmin();

    $this->renderAllPosts($routeData);
  }

  public function new (RouteData $routeData)
  {
    $this->isAdmin();
    $this->renderAddProduct($routeData);
  }

  public function edit(RouteData $routeData)
  {
    $this->isAdmin();



    // Получаем главные категориии, подкатегории и бренды
    // $mainCats = $this->categoryRepository->getMainCats();
    // $subCats = $this->categoryRepository->getSubCats();


    // Загружаем объект категории
    // $selectedSubCat = $post->getCategory();

    // Главный раздел
    // $selectedMaiCat = $this->categoryRepository->getParentCategory($selectedSubCat);

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

   
    $this->renderEditPost($routeData);

  }

  public function delete(RouteData $routeData)
  {
    $this->isAdmin();

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
    $this->renderDeletePost($routeData);

  }

  
  private function renderAllPosts(RouteData $routeData): void
  {
    // Название страницы
    $pageTitle = 'Блог - все записи';

    $postsPerPage = 9;

    // Устанавливаем пагинацию
    $pagination = pagination($postsPerPage, 'posts');
    $posts = $this->adminPostService->getAllPosts($pagination);
    $total = $this->adminPostService->getTotalCount();

    // Формируем единую модель для передачи в шаблон
    $postViewModel = [
        'posts' => $posts,
        'total' => $total,
    ];
        

    $this->renderLayout('blog/all',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
      'postViewModel' => $postViewModel,
      'pagination' => $pagination,
      'flash' => $this->flash
    ]);
  }

  private function renderNewPost(RouteData $routeData): void
  {
    // Название страницы
    $pageTitle = "Добавить новую статью";
    // $pageClass = "admin-page";

    $this->renderLayout('blog/new',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
      'flash' => $this->flash
    ]);
  }

  private function renderEditPost(RouteData $routeData): void
  {
    // Название страницы
    $pageTitle = "Редактирование статьи";
    // $pageClass = "admin-page";

    // Получаем пост по Id 
    $postId = $routeData->getUriGetParam();
    // $post = $this->adminPostService->getPost((int) $postId);
    $postViewData =  $this->adminPostService->getPostViewData((int) $postId);

    $this->renderLayout('blog/edit',  [
      'postViewData' => $postViewData,
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
      'flash' => $this->flash
    ]);
  }

  private function renderDeletePost(RouteData $routeData): void
  {
    // Название страницы
    $pageTitle = "Удалить статью";
    // $pageClass = "admin-page";

    // Получаем пост по Id 
    $postId = $routeData->getUriGetParam();
    $post = $this->adminPostService->getPost((int) $postId);

    // Получаем главные категориии, подкатегории и бренды
    // $mainCats = $this->categoryRepository->getMainCats();
    // $subCats = $this->categoryRepository->getSubCats();
    // $brands = $this->brandRepository->getAllBrands();

    // Загружаем объект категории
    // $selectedSubCat = $product->getCategory();

    // Главный раздел
    // $selectedMaiCat = $this->categoryRepository->getParentCategory($selectedSubCat);

    $this->renderLayout('blog/delete',  [
      'post' => $post,
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
    ]);
  }
}