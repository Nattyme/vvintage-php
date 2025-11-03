<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Admin\User;

use Vvintage\Routing\RouteData;
use Vvintage\Controllers\Admin\BaseAdminController;
use Vvintage\Services\Admin\User\AdminUserService;
use Vvintage\Repositories\User\UserRepository;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Session\SessionService;

final class AdminUserController extends BaseAdminController 
{
  private AdminUserService $adminUserService;

  public function __construct(
    FlashMessage $flash,
    SessionService $sessionService
  )
  {
    parent::__construct($flash, $sessionService);
    $this->adminUserService = new AdminUserService();
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

    $users = $this->adminUserService->getAllUsers($pagination);
    // $users = $this->userRepository->getAllUsers($pagination);
    $total = $this->adminUserService->getAllUsersCount();
    // $total = $this->userRepository->getAllUsersCount();
        
    $this->renderLayout('users/all',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
      'users' => $users,
      'total' => $total,
      'searchQuery' => $searchQuery,
      'pagination' => $pagination,
      'flash' => $this->flash
    ]);

  }



  // private function renderDelete(RouteData $routeData): void
  // {
  //   // Название страницы
  //   $pageTitle = 'Бренды';

  //   $brandsPerPage = 9;

  //   // Устанавливаем пагинацию
  //   $pagination = pagination($brandsPerPage, 'brands');
  //   $brands = $this->brandRepository->getAllBrands($pagination);
  //   $total = $this->brandRepository->getAllBrandsCount();
        
  //   $this->renderLayout('brands/all',  [
  //     'pageTitle' => $pageTitle,
  //     'routeData' => $routeData,
  //     'brands' => $brands,
  //     'pagination' => $pagination
  //   ]);

  // }

}