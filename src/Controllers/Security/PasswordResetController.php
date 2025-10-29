<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Security;

/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;

use Vvintage\Services\Security\PasswordResetService;
use Vvintage\Repositories\User\UserRepository;
use Vvintage\Services\Validation\PasswordResetValidator;
use Vvintage\Routing\RouteData;

final class PasswordResetController extends BaseController
{
  private PasswordResetService $service;

  public function __construct()
  {
      parent::__construct(); // Важно!
      $this->service = new PasswordResetService( new UserRepository(), $this->flash);
  }

  public function index ($routeData) 
  {
    if (isset($_POST['lost-password'])) {
      $validator = new PasswordResetValidator();
      $resultEmail = false;

      if ($validator->validate($_POST)) {
        $result = $this->service->processPasswordResetRequest($_POST['email']);

        if ($result['success']) {
          $resultEmail = true;
          $this->flash->pushSuccess('Проверьте почту', 'На указанную почту был отправлен email с ссылкой для сброса пароля.');
   
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

