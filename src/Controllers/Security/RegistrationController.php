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

  public function __construct(
    private RegistrationService $service,
    private RegistrationValidator $validator,
    protected PageService $pageService,
    protected SeoService $seoService,
    protected SessionService $sessionService,
    protected FlashMessage $flash
  )
  {
    parent::__construct($flash, $sessionService, $pageService, $seoService); // Важно!
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