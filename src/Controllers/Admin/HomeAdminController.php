<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Admin;
use Vvintage\Routing\RouteData;

class HomeAdminController extends BaseAdminController 
{
  public function __construct()
  {
    
  }

  public function index (RouteData $routeData)
  {

    $this->renderHomeAdmin($routeData);
    
  }

  private function renderHomeAdmin(RouteData $routeData): void
  {
    // Название страницы
    $pageTitle = 'Панель управления - статистика сайта';

    $this->renderLayout('admin/main/index',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
    ]);
  }

}