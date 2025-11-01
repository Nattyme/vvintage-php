<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Security;

/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;

use Vvintage\Services\Page\PageService;
use Vvintage\Services\SEO\SeoService;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Security\RegistrationService;
use Vvintage\Services\Session\SessionService;
use Vvintage\Services\AdminPanel\AdminPanelService;

use Vvintage\Services\Validation\RegistrationValidator;

final class RegistrationController extends BaseController
{

  public function __construct(
    protected SessionService $sessionService, 
    protected AdminPanelService $adminPanelService,
    private RegistrationValidator $validator,
    private RegistrationService $service, 
    private PageService $pageService, 
    private FlashMessage $flash, 
    private SeoService $seoService
  )
  {
      parent::__construct($sessionService, $adminPanelService); // Важно!
  }

  public function index ($routeData) {
    // Если форма отправлена - делаем регистрацию
    if ( isset($_POST['register']) ) {
    
      if ( $this->validator->validate( $_POST )) {
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