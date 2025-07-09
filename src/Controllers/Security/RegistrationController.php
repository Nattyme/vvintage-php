<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Security;

use Vvintage\Services\Security\RegistrationService;
use Vvintage\Services\Validation\RegistrationValidator;
use Vvintage\Services\Messages\FlashMessage;


final class RegistrationController 
{
  public static function index ($routeData) {
    // Если форма отправлена - делаем регистрацию
    if ( isset($_POST['register']) ) {
      $regService = new RegistrationService();
      $notes = new FlashMessage ();   
      $validator = new RegistrationValidator($regService, $notes);

      if ( $validator->validate( $_POST )) {
        $newUser = $regService->createNewUser( $_POST );

        if (!$newUser) {
          $notes->pushError('Что-то пошло не так. Попробуйте ещё раз.');
        }
      }
    }

    // Показываем форму
    self::renderForm($routeData);
  }

  private static function renderForm ($routeData) {
    $pageTitle = "Регистрация";
    $pageClass = "authorization-page";
 
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