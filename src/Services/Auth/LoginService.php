<?php
declare(strict_types=1);

namespace Vvintage\Services\Auth;

use Vvintage\Models\User\User;
use Vvintage\Repositories\UserRepository;
use Vvintage\Services\Validation\LoginValidator;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Auth\SessionManager;

final class LoginService
{
  private UserRepository $userRepository;
  private FlashMessage $notes;

  public function __construct(UserRepository $userRepository, FlashMessage $notes)
  {
    $this->userRepository = $userRepository;
    $this->notes = $notes;
  }

  public function login(array $data): ?User
  {
    $validator = new LoginValidator($this->userRepository, $this->notes);

    if (!$validator->validate($data)) {
      return null;
    }

    $user = $this->userRepository->findUserByEmail($data['email']);

    if (!$user || !password_verify($data['password'], $user->getPassword())) {
      $this->notes->pushError('Неверный email или пароль');
      return null;
    }

    SessionManager::setUserSession($user);
    return $user;
  }
}
