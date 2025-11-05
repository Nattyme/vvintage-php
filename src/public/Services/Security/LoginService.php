<?php
declare(strict_types=1);

namespace Vvintage\Public\Services\Security;

use Vvintage\Models\User\User;
use Vvintage\Public\Services\User\UserService;


final class LoginService 
{
  private UserService $userService;

  public function __construct()
  {
    $this->userService = new UserService();
  }

  public function login(array $data): ?User
  {
    // Ищем пользователя
    $user = $this->userService->findUserByEmail($data['email']);
    if (!$user) throw new \Exception('Пользователь с таким email не найден');

    // Проверяем список заблокированных
    $isBlocked = $this->userService->findBlockedUserByEmail($data['email']);
    if ($isBlocked) throw new \Exception('Ошибка, невозможно зайти в профиль');

    // Проверяем пароль
    $passwordIsValid = password_verify( $data['password'], $user->getPassword() );
    if (!$passwordIsValid)  throw new \Exception('Введен неверный пароль');

    return $user;
  }


}
