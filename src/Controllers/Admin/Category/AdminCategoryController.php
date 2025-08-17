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
  }

  public function all(RouteData $routeData)
  {
    $this->isAdmin();
    $this->renderAll($routeData);
  }

  public function edit(RouteData $routeData)
  {
    $this->isAdmin();
    $this->renderEdit($routeData);
  }

  public function new(RouteData $routeData)
  {
    $this->isAdmin();
    $this->renderNew($routeData);
  }

  public function delete (RouteData $routeData)
  {
    $this->isAdmin();
    $this->renderDelete($routeData);
  }

  private function renderAll(RouteData $routeData): void
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
      'routeData' => $routeData,
      'cats' => $cats,
      'mainCats' => $mainCats,
      'searchQuery' => $searchQuery,
      'filterSection' => $filterSection,
      'pagination' => $pagination,
      'flash' => $this->flash
    ]);

  }

  private function renderNew(RouteData $routeData): void
  {
    $viewPath = 'categories/new';
    $pageTitle = 'Категория - создание';

        
    $this->renderLayout($viewPath,  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
      'flash' => $this->flash
    ]);
  }

  private function renderEdit(RouteData $routeData): void
  {
    $viewPath = 'categories/edit';

    // Название страницы
    $pageTitle = 'Категория - редактирование';
    $id = (int) $routeData->uriGetParam;
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

  private function renderDelete(RouteData $routeData): void
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