<?php
declare(strict_types=1);

namespace Vvintage\Services\Security;

use Vvintage\Models\User\User;
use Vvintage\Services\User\UserService;
use Vvintage\Services\Base\BaseService;
use Vvintage\Repositories\UserRepository;
use Vvintage\Services\Session\SessionService;


final class RegistrationService extends BaseService
{

  private UserService $userService;
  private SessionService $sessionService;

  public function __construct()
  {
    parent::__construct(); // Важно!
    $this->userService = new UserService();
    $this->sessionService = new SessionService();
  }
 
  public function registrateUser (array $postData): User
  {
    // Создаем нового пользователя
    $newUser = $this->userService->createUser( $postData );

    // Автологин 
    if (!$newUser) throw new \Exception('Не удалось зарегистрироваться. Попробуйте ещё раз.');
    $this->autoLoginNewUser($newUser);

    return $newUser;
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
  }

}