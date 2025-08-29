<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Admin\Category;

use Vvintage\Routing\RouteData;
use Vvintage\Controllers\Admin\BaseAdminController;
use Vvintage\Services\Admin\Category\AdminCategoryService;
use Vvintage\Services\Messages\FlashMessage;

final class AdminCategoryController extends BaseAdminController 
{
  private AdminCategoryService $service;
  private FlashMessage $flash;

  public function __construct()
  {
    parent::__construct();
    $this->service = new AdminCategoryService();
    $this->flash = new FlashMessage();
    $this->validator = new AdminBrandValidator();
  }

  public function all(RouteData $routeData)
  {
    $this->isAdmin();
    $this->setRouteData($routeData);
    $this->renderAll();
  }

  public function edit(RouteData $routeData)
  {
    $this->isAdmin();
    $this->renderEdit($routeData);
  }

  public function new(RouteData $routeData)
  {
    $this->isAdmin();
    $this->setRouteData($routeData);
    $this->renderNew();
  }

  public function delete (RouteData $routeData)
  {
    $this->isAdmin();
    $this->setRouteData($routeData);
    $this->renderDelete();
  }

  private function renderAll(): void
  {
    // Название страницы
    $pageTitle = 'Категории';

    // Получаем данные из GET-запроса
    $searchQuery = $_GET['query'] ?? '';
    $filterSection = $_GET['action'] ?? ''; // имя селекта - action

    $categoryPerPage = 9;

    // Устанавливаем пагинацию
    $pagination = pagination($categoryPerPage, 'categories');
    $cats = $this->service->getAllCategories($pagination);
    $mainCats = $this->service->getMainCategories();
    $total = $this->service->getAllCategoriesCount();
        
    $this->renderLayout('categories/all',  [
      'pageTitle' => $pageTitle,
      'routeData' => $this->routeData,
      'cats' => $cats,
      'mainCats' => $mainCats,
      'searchQuery' => $searchQuery,
      'filterSection' => $filterSection,
      'pagination' => $pagination,
      'flash' => $this->flash
    ]);

  }

  private function renderNew(): void
  {
    $viewPath = 'categories/new';
    $pageTitle = 'Категория - создание';

    $uriGet = $this->routeData->uriGet ?? null;
    $parentId = $this->routeData->uriGet ?? null;
    $mainCats = $this->service->getMainCategories();
    
    if( $parentId) {    
      $parentId = (int) $parentId;
      $parentCategory = $this->service->getCategoryById($id);
    }

    
    if ($parentId && !$parentCategory) {
        $this->flash->pushError('Раздел для добавления категории не найден. Выберите другой');
        $this->redirect('category');
    }

    if(isset($_POST['submit'])) {
      dd($_POST);
      $validate = $this->validator->new($_POST);
      // Проверка CSRF
      if (!check_csrf($_POST['csrf'] ?? '')) {
          $this->flash->pushError('Неверный токен безопасности.');
      } else {
          // Валидация
          $validate = $brandId ? $this->validator->edit($_POST) : $this->validator->new($_POST);

          if (!$validate) {
              $this->flash->pushError($brandId 
                  ? 'Не удалось обновить бренд. Проверьте данные.' 
                  : 'Не удалось сохранить новый бренд. Проверьте данные.');
          } else {
              $translations = [];
              foreach ($_POST['title'] as $lang => $title) {
                  $translations[$lang] = [
                      'title' => $_POST['title'][$lang] ?? '',
                      'description' => $_POST['description'][$lang] ?? '',
                      'meta_title' => $_POST['meta_title'][$lang] ?? '',
                      'meta_description' => $_POST['meta_description'][$lang] ?? '',
                  ];
              }

              $mainLang = 'ru';

              $brandDTO = new BrandDTO([
                  'title' => $_POST['title'][$mainLang] ?? '',
                  'description' => $_POST['description'][$mainLang] ?? '',
                  'image' => $_POST['image'] ?? '',
                  'translations' => $translations,
              ]);

              $brand = Brand::fromDTO($brandDTO);

              $saved = $brandId
                  ? $this->service->updateBrand($brandId, $_POST)
                  : $this->service->createBrand($brandDTO);

              if ($saved) {
                  $this->flash->pushSuccess($brandId ? 'Бренд успешно обновлен.' : 'Бренд успешно создан.');
                  header('Location: ' . HOST . 'admin/brand');
                  exit; // здесь return нужен, чтобы не рендерить форму
              } else {
                  $this->flash->pushError('Не удалось сохранить бренд. Попробуйте ещё раз.');
              }
          }
      }
    }

    $this->renderLayout($viewPath,  [
      'pageTitle' => $pageTitle,
      'routeData' => $this->routeData,
      'flash' => $this->flash,
      'uriGet' => $uriGet,
      'currentMainCategory' => $currentMainCategory
      
    ]);
  }

  private function renderEdit(RouteData $routeData): void
  {
    $viewPath = 'categories/edit';

    // Название страницы
    $pageTitle = 'Категория - редактирование';
    $id = (int) $routeData->uriGet;
    $pageClass = 'admin-page';

    // Задаем название страницы и класс
    if( isset($_POST['submit'])) {
      // Проверка токена
      if (!check_csrf($_POST['csrf'] ?? '')) {
        $_SESSION['errors'][] = ['error', 'Неверный токен безопасности'];
      }

      // Проверка на заполненность названия
      if( trim($_POST['title']) == '' ) {
        $_SESSION['errors'][] = ['title' => 'Введите название бренда'];
      } 

      // Если нет ошибок
      if ( empty($_SESSION['errors'])) {
        $brand = $this->brandRepository->getBrandById((int) $routeData->uriGetParam);
        // $brand->title = $_POST['title'];

        // R::store($brand);

        $_SESSION['success'][] = ['title' => 'Бренд успешно обновлен.'];
      }
    }

    // Запрос постов в БД с сортировкой id по убыванию
    $category = $this->service->getCategoryById( $id );

        
    $this->renderLayout($viewPath,  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
      'category' => $category,
      'languages' => $this->languages,
      'currentLang' => $this->currentLang,
      'flash' => $this->flash
    ]);

  }

  private function renderDelete(): void
  {
    // Название страницы
    $pageTitle = 'Бренды';

    $brandsPerPage = 9;

    // Устанавливаем пагинацию
    $pagination = pagination($brandsPerPage, 'brands');
    $brands = $this->brandRepository->getAllBrands($pagination);
    $total = $this->brandRepository->getAllBrandsCount();
        
    $this->renderLayout('brands/all',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
      'brands' => $brands,
      'pagination' => $pagination,
      'flash' => $this->flash
    ]);

  }

}