<?php
declare(strict_types=1);

namespace Vvintage\public\Controllers\Security;

/** Базовый контроллер страниц*/
use Vvintage\public\Controllers\Base\BaseController;

use Vvintage\public\Services\SEO\SeoService;
use Vvintage\public\Services\Page\PageService;
use Vvintage\public\Services\Messages\FlashMessage;
use Vvintage\public\Services\Session\SessionService;
use Vvintage\public\Services\Security\PasswordResetService;
use Vvintage\public\Services\Validation\PasswordResetValidator;

use Vvintage\Repositories\User\UserRepository;
use Vvintage\Routing\RouteData;

final class PasswordResetController extends BaseController
{
  protected SeoService $seoService;
  protected PageService $pageService;
  private PasswordResetService $service;
  private PasswordResetValidator $validator;

  public function __construct(
    FlashMessage $flash,
    SessionService $sessionService,
    SeoService $seoService
  )
  {
    $this->seoService = $seoService;
    $this->pageService = new PageService();
    parent::__construct($flash, $sessionService, $this->pageService, $this->seoService); // Важно!
    $this->service = new PasswordResetService( new UserRepository(), $this->flash);
    $this->validator = new PasswordResetValidator($this->service);
  }

  public function index ($routeData) 
  {
    $this->setRouteData($routeData);

    if (isset($_POST['lost-password'])) {
      try {
        $result = true;
        $this->validator->validate($_POST);
        $this->service->processPasswordResetRequest($_POST['email']);
        $this->flash->pushSuccess('Проверьте почту', 'На указанную почту был отправлен email с ссылкой для сброса пароля.');
     
      }
      catch (\Exception $error) {
        $result = false;
        $this->flash->pushError($error->getMessage());
      }
    }
    
    // Показываем форму
    $this->renderForm($routeData, $result ?? null);
  }

  private function renderForm (RouteData $routeData, ?bool $result) {
    // Название страницы
    $page = $this->pageService->getPageBySlug($routeData->uriModule);
    $pageModel = $this->pageService->getPageModelBySlug( $routeData->uriModule );
    $seo = $this->seoService->getSeoForPage('profile-edit', $pageModel);


    $pageTitle = "Восстановить пароль";
    $currentLang =  $this->service->currentLang;
    $languages = $this->service->languages;

    $this->renderAuthLayout('lost-password', [
      'page' => $page,
      'result' => $result,
      'seo' => $seo,
      'pageTitle' => $pageTitle,
      'currentLang' => $currentLang,
      'languages' => $languages
    ]);

  }
}

