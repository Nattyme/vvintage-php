<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Admin;

use Vvintage\Routing\RouteData;
use Vvintage\Controllers\Admin\BaseAdminController;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Session\SessionService;

/** Сервисы */
use Vvintage\Services\Admin\AdminStatsService;

class HomeAdminController extends BaseAdminController 
{
  public AdminStatsService $adminStatsService;

  public function __construct(
    FlashMessage $flash,
    SessionService $sessionService
  )
  {
    parent::__construct($flash, $sessionService);
    $this->adminStatsService = new AdminStatsService();
  }

  public function index (RouteData $routeData)
  {
    $this->renderHomeAdmin($routeData);
    
  }

  private function renderHomeAdmin(RouteData $routeData): void
  {
    // Название страницы
    $pageTitle = 'Cтатистика сайта';

    $this->renderLayout('main/index',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
    ]);
  }

}