<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Security;

use Vvintage\Controllers\Base\BaseController; /** Базовый контроллер страниц*/
use Vvintage\Services\SEO\SeoService;
use Vvintage\Services\Page\PageService;
use Vvintage\Services\Security\RegistrationService;
use Vvintage\Services\Validation\RegistrationValidator;

final class RegistrationController extends BaseController
{
  private SeoService $seoService;
  private PageService $pageService;
  private RegistrationService $service;

  public function __construct(SeoService $seoService)
  {
      parent::__construct(); // Важно!
      $this->pageService = new PageService();
      $this->service = new RegistrationService();
  }

  public function index ($routeData) {
    // Если форма отправлена - делаем регистрацию
    if ( isset($_POST['register']) ) {
      $validator = new RegistrationValidator();

      if ( $validator->validate( $_POST )) {
        $newUser = $this->service->registrateUser( $_POST );

        if (!$newUser) {
          $this->flash->pushError('Что-то пошло не так. Попробуйте ещё раз.');
        }
      }
    }

    // Показываем форму
    $this->renderForm($routeData);
  }

  private function renderForm ($routeData) {
    // Название страницы
    $page = $this->pageService->getPageBySlug($routeData->uriModule);
    $pageModel = $this->pageService->getPageModelBySlug( $routeData->uriModule );
    $seo = $this->seoService->getSeoForPage('profile-edit', $pageModel);
    
    $pageTitle = "Регистрация";
    $pageClass = "authorization-page";
    $flash = $this->flash;
    $currentLang =  $this->service->currentLang;
    $languages = $this->service->languages;
    
    //Сохраняем код ниже в буфер
    ob_start();
    include ROOT . 'views/login/form-registration.tpl';
    //Записываем вывод из буфера в пепеменную
    $content = ob_get_contents();
    //Окончание буфера, очищаем вывод
    ob_end_clean();

    include ROOT . "views/_page-parts/_head.tpl";
    include ROOT . "views/login/login-page.tpl";
    include ROOT . "views/_page-parts/_foot.tpl";

  }
}