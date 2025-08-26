<?php
declare(strict_types=1);

namespace Vvintage\Services\Security;
use Vvintage\Models\User\User;
use Vvintage\Repositories\UserRepository;
use Vvintage\Services\User\UserService;
use Vvintage\Services\Session\SessionService;
use Vvintage\Services\Base\BaseService;

use RedBeanPHP\R;

final class RegistrationService extends BaseService
{

  private UserService $userService;
  private SessionService $sessionService;

  public function __constuct(UserService $userService, SessionServuce $sessionService)
  {
    parent::__construct(); // Важно!
    $this->userService = new UserService();
    $this->sessionService = new SessionService();
  }
 
  public function registrateUser (array $postData):void 
  {
    // Создаем нового пользователя
    $newUser = $this->userService->createUser( $postData );

    // Автологин 
    if ($newUser) {
      $this->autoLoginNewUser($newUser);
    }
  }

  public function isEmailFree (string $emailData): int
  {

    return R::count('users', 'email = ?', array($emailData));
  }

  public function findBlockedUserByEmail(string $emailData): bool
  {
    dd($this->userService);
    return $this->userService->findBlockedUserByEmail($emailData);
  }

  private function autoLoginNewUser (User $user): void
  {
    $this->sessionService->setUserSession($user);

    // Сообщение об успехе
    $_SESSION['success'][] = [
      'title' => 'Регистрация завершена.', 'desc'=>'Заполните свой профиль для дальнейшего пользования сайтом'
    ];

    // Перенаправляем
    header('Location: ' . HOST . 'profile-edit');
    exit();
  }

}