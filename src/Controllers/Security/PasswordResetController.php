<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Security;

/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;

use Vvintage\Services\SEO\SeoService;
use Vvintage\Services\Page\PageService;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Session\SessionService;
use Vvintage\Services\Security\PasswordResetService;
use Vvintage\Services\Validation\PasswordResetValidator;

use Vvintage\Repositories\User\UserRepository;
use Vvintage\Routing\RouteData;

final class PasswordResetController extends BaseController
{
  private SeoService $seoService;
  private PageService $pageService;
  private PasswordResetService $service;
  private PasswordResetValidator $validator;

  public function __construct(
    FlashMessage $flash,
    SessionService $sessionService,
    SeoService $seoService
  )
  {
      parent::__construct($flash, $sessionService); // Важно!
      $this->seoService = $seoService;
      $this->pageService = new PageService();
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

