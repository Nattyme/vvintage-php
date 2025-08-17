<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Security;

/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;

use Vvintage\Services\Security\PasswordResetService;
use Vvintage\Repositories\User\UserRepository;
use Vvintage\Services\Validation\PasswordResetValidator;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Routing\RouteData;

// Пеервод на другие языки
use Vvintage\Config\LanguageConfig;
use Vvintage\Services\Translator\Translator;

final class PasswordResetController extends BaseController
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

  public function index ($routeData) 
  {
    if (isset($_POST['lost-password'])) {
      $resetPassService = new PasswordResetService( new UserRepository(), $this->flash);
      $validator = new PasswordResetValidator($resetPassService, $this->flash);
      $resultEmail = false;

      if ($validator->validate($_POST)) {
        $result = $resetPassService->processPasswordResetRequest($_POST['email']);

        if ($result['success']) {
          $resultEmail = true;
          $this->flash->pushSuccess('Проверьте почту', 'На указанную почту был отправлен email с ссылкой для сброса пароля.');
   
        } else {
          foreach ($result['errors'] as $error) {
            $this->flash->pushError($error['title']);
          }
        }

      }
    }
    
    // Показываем форму
    self::renderForm($routeData, $resultEmail ?? null);
  }

  private function renderForm (RouteData $routeData, ?bool $resultEmail = false) {
    $pageTitle = "Восстановить пароль";
    $pageClass = "authorization-page";
    $flash = $this->flash;
 
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

