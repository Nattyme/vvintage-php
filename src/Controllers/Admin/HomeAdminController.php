<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Admin;

use Vvintage\Routing\RouteData;
use Vvintage\Controllers\Admin\BaseAdminController;

/** Сервисы */
use Vvintage\Services\Admin\AdminStatsService;

class HomeAdminController extends BaseAdminController 
{
  public AdminStatsService $adminStatsService;

  public function __construct()
  {
    parent::__construct();
    $this->adminStatsService = new AdminStatsService();
  }

  public function index (RouteData $routeData)
  {
    $this->renderHomeAdmin($routeData);
    
  }

  private function renderHomeAdmin(RouteData $routeData): void
  {
    // Название страницы
    $pageTitle = 'Панель управления - статистика сайта';

    $this->renderLayout('main/index',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
    ]);
  }

}