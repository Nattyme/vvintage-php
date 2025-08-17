<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Security;

/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;

use Vvintage\Services\Security\RegistrationService;
use Vvintage\Services\Validation\RegistrationValidator;
use Vvintage\Services\Messages\FlashMessage;

// Пеервод на другие языки
use Vvintage\Config\LanguageConfig;
use Vvintage\Services\Translator\Translator;


final class RegistrationController extends BaseController
{
  protected array $languages;
  protected string $currentLang;
  protected Translator $translator;
  private FlashMessage $flash;

  public function __construct(FlashMessage $flash)
  {
      $this->translator = setTranslator(); // берём уже установленный переводчик
      $this->languages = LanguageConfig::getAvailableLanguages();
      $this->currentLang = LanguageConfig::getCurrentLocale();
      $this->flash = $flash;
  }

  public function index ($routeData) {
    // Если форма отправлена - делаем регистрацию
    if ( isset($_POST['register']) ) {
      $regService = new RegistrationService();
      $validator = new RegistrationValidator($regService, $this->flash);

      if ( $validator->validate( $_POST )) {
        $newUser = $regService->registrateUser( $_POST );

        if (!$newUser) {
          $this->flash->pushError('Что-то пошло не так. Попробуйте ещё раз.');
        }
      }
    }

    // Показываем форму
    $this->renderForm($routeData);
  }

  private function renderForm ($routeData) {
    $pageTitle = "Регистрация";
    $pageClass = "authorization-page";
    $flash = $this->flash;

    
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