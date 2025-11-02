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
    if (isset($_POST['lost-password'])) {
      try {
        $resultEmail = false;
        $this->validator->validate($_POST);
        $resultEmail = $this->service->processPasswordResetRequest($_POST['email']);
        $this->flash->pushSuccess('Проверьте почту', 'На указанную почту был отправлен email с ссылкой для сброса пароля.');
      }
      catch (\Exception $error) {
        $this->flash->pushError($error->getMessage());
      }
    }
    
    // Показываем форму
    $this->renderForm($routeData, $resultEmail ?? null);
  }

  private function renderForm (RouteData $routeData, ?bool $resultEmail = false) {
    // Название страницы
    $page = $this->pageService->getPageBySlug($routeData->uriModule);
    $pageModel = $this->pageService->getPageModelBySlug( $routeData->uriModule );
    $seo = $this->seoService->getSeoForPage('profile-edit', $pageModel);
    
    $pageTitle = "Восстановить пароль";
    $pageClass = "authorization-page";
    $flash = $this->flash;
    $currentLang =  $this->service->currentLang;
    $languages = $this->service->languages;
 
    //Сохраняем код ниже в буфер
    ob_start();
    include ROOT . 'views/login/lost-password.tpl';
    //Записываем вывод из буфера в пепеменную
    $content = ob_get_contents();
    //Окончание буфера, очищаем вывод
    ob_end_clean();


    include ROOT . "views/_page-parts/_head.tpl";
    include ROOT . "views/login/login-page.tpl";
    include ROOT . "views/_page-parts/_foot.tpl";

  }
}

