<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Admin\User;

use Vvintage\Routing\RouteData;
use Vvintage\Controllers\Admin\BaseAdminController;
use Vvintage\Repositories\User\UserRepository;

final class AdminUserController extends BaseAdminController 
{
  private UserRepository $userRepository;

  public function __construct()
  {
    parent::__construct();
    $this->userRepository = new UserRepository();
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

  // public function new(RouteData $routeData)
  // {
  //   $this->isAdmin();
  //   $this->renderNew($routeData);
  // }

  public function block(RouteData $routeData)
  {
    $this->isAdmin();
    $this->renderDelete($routeData);
  }

  private function renderAll(RouteData $routeData): void
  {
    // Название страницы
    $pageTitle = 'Пользователи';

    // Получаем данные из GET-запроса
    $searchQuery = $_GET['query'] ?? '';
    $filterSection = $_GET['action'] ?? ''; // имя селекта - action

    $usersPerPage = 9;

    // Устанавливаем пагинацию
    $pagination = pagination($usersPerPage, 'users');

    $users = $this->userRepository->getAllUsers($pagination);
    $total = $this->userRepository->getAllUsersCount();
        
    $this->renderLayout('users/all',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
      'users' => $users,
      'total' => $total,
      'searchQuery' => $searchQuery,
      'pagination' => $pagination
    ]);

  }

  private function renderNew(RouteData $routeData): void
  {
    // Название страницы
    $pageTitle = 'Бренды - новая запись';

    // Устанавливаем пагинацию
    $pagination = pagination($brandsPerPage, 'brands');
    $brands = $this->brandRepository->getAllBrands($pagination);
    $total = $this->brandRepository->getAllBrandsCount();
        
    $this->renderLayout('brands/all',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
      'brands' => $brands,
      'pagination' => $pagination
    ]);

  }

  private function renderEdit(RouteData $routeData): void
  {
    // Название страницы
    $pageTitle = 'Бренды';

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

    $currentLang = LanguageConfig::getCurrentLocale();

    // Запрос постов в БД с сортировкой id по убыванию
    $brand = $this->brandRepository->getBrandById( (int) $routeData->uriGetParam);


        
    $this->renderLayout('brands/edit',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
      'brand' => $brand,
      'languages' => $this->languages,
      'currentLang' => $currentLang
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
      'pagination' => $pagination
    ]);

  }

}