<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Security;

use Vvintage\Services\Security\PasswordResetService;
use Vvintage\Repositories\UserRepository;
use Vvintage\Services\Validation\PasswordResetValidator;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Routing\RouteData;

final class PasswordResetController {
  private FlashMessage $notes;

  public function __construct(FlashMessage $notes)
  {
      $this->notes = $notes;
  }

  public function index ($routeData) 
  {
    if (isset($_POST['lost-password'])) {
      $resetPassService = new PasswordResetService( new UserRepository(), $this->notes);
      $validator = new PasswordResetValidator($resetPassService, $this->notes);
      $resultEmail = false;

      if ($validator->validate($_POST)) {
        $result = $resetPassService->processPasswordResetRequest($_POST['email']);

        if ($result['success']) {
          $resultEmail = true;
          $this->notes->pushSuccess('Проверьте почту', 'На указанную почту был отправлен email с ссылкой для сброса пароля.');
   
        } else {
          foreach ($result['errors'] as $error) {
            $this->notes->pushError($error['title']);
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

