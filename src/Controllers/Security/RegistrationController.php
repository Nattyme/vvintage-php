<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Security;

use Vvintage\Controllers\Base\BaseController; /** Базовый контроллер страниц*/
use Vvintage\Services\SEO\SeoService;
use Vvintage\Services\Page\PageService;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Session\SessionService;
use Vvintage\Services\Security\RegistrationService;
use Vvintage\Services\Validation\RegistrationValidator;

final class RegistrationController extends BaseController
{
  protected SeoService $seoService;
  protected PageService $pageService;
  private RegistrationService $service;
  private RegistrationValidator $validator;

  public function __construct(
    PageService $pageService,
    SeoService $seoService,
    SessionService $sessionService,
    FlashMessage $flash
  )
  {
    $this->pageService = new PageService();
    $this->service = new RegistrationService();
    $this->seoService = new SeoService();
    $this->validator = new RegistrationValidator();
    parent::__construct($flash, $sessionService, $this->pageService, $this->seoService); // Важно!
  }

  public function index ($routeData) {
    $this->setRouteData($routeData);

    // Если форма отправлена - делаем регистрацию
    if ( isset($_POST['register']) ) {

      try {
        $this->validator->validate( $_POST ); // валидация, если ошибка - исключение
        $newUser = $this->service->registrateUser( $_POST ); // регистрируем пользователя

        // Уведомление 
        $this->flash->pushSuccess('Вы успешно зарегистрировались. Добро пожаловать!');
        $this->redirect('profile/edit');  
      }
      catch (\Exception $error) {
        $this->flash->pushError($error->getMessage());
      }
      
    }

    // Показываем форму
    $this->renderForm($routeData);
  }

  private function renderForm ($routeData) {
    // // Название страницы
    // $page = $this->pageService->getPageBySlug($routeData->uriModule);
    // $pageModel = $this->pageService->getPageModelBySlug( $routeData->uriModule );
    // $seo = $this->seoService->getSeoForPage('profile-edit', $pageModel);
    
    $pageTitle = "Регистрация";
    $currentLang =  $this->service->currentLang;
    $languages = $this->service->languages;

    $this->renderAuthLayout('form-registration', [
      'pageTitle' => $pageTitle,
      'currentLang' => $currentLang,
      'languages' => $languages
    ]);
  }
}