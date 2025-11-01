<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Admin;

use Vvintage\Routing\RouteData;
use Vvintage\Controllers\Admin\BaseAdminController;

/** Сервисы */
use Vvintage\Services\Locale\LocaleService;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Session\SessionService;
use Vvintage\Services\Admin\AdminStatsService;

class HomeAdminController extends BaseAdminController 
{

  public function __construct(
    protected AdminStatsService $statsService,
    protected LocaleService $localeService, 
    protected SessionService $sessionService, 
    protected FlashMessage $flash
  )
  {
    parent::__construct($localeService, $sessionService, $flash);
  }

  public function index (RouteData $routeData)
  {
    $this->renderHomeAdmin($routeData);
    
  }

  private function renderHomeAdmin(RouteData $routeData): void
  {
    // Название страницы
    $pageTitle = 'Cтатистика сайта';
    $stats = $this->statsService->getSummary();

    $this->renderLayout('main/index',  [
      'stats' => $stats,
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
    ]);
  }

}