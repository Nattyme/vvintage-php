<?php
declare(strict_types=1);

namespace Vvintage\Services\Security;
use Vvintage\Models\User\User;
use Vvintage\Repositories\UserRepository;
use Vvintage\Services\User\UserService;
use Vvintage\Services\Auth\SessionManager;
use Vvintage\Services\Address\AddressService;
use Vvintage\Repositories\AddressRepository;
use Vvintage\Services\Base\BaseService;

use RedBeanPHP\R;

final class RegistrationService extends BaseService
{

  public function __constuct()
  {
    parent::__construct(); // Важно!
  }
 
  public function registrateUser (array $postData):void 
  {
    // Создаем нового пользователя
    $userService = new UserService( new UserRepository(), new AddressService(new AddressRepository()));
    $newUser = $userService->createUser( $postData );

    // Автологин 
    if ($newUser) {
      $this->autoLoginNewUser($newUser);
    }
  }

  public function isEmailFree (string $emailData): int
  {
    return R::count('users', 'email = ?', array($emailData));
  }

  public function isEmailBlocked (string $emailData): bool
  {
    $blockedUsers  = R::findOne( 'blockedusers', ' email = ? ', [ $_POST['email'] ] );
    return $blockedUsers !== NULL ? true : false;
  }

  private function autoLoginNewUser (User $user): void
  {
    SessionManager::setUserSession($user);

    // Сообщение об успехе
    $_SESSION['success'][] = [
      'title' => 'Регистрация завершена.', 'desc'=>'Заполните свой профиль для дальнейшего пользования сайтом'
    ];

    // Перенаправляем
    header('Location: ' . HOST . 'profile-edit');
    exit();
  }

}