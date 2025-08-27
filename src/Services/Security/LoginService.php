<?php
declare(strict_types=1);

namespace Vvintage\Services\Security;

use Vvintage\Models\User\User;
use Vvintage\Repositories\User\UserRepository;
use Vvintage\Services\Validation\LoginValidator;
use Vvintage\Services\Session\SessionService;
use Vvintage\Services\Base\BaseService;

final class LoginService extends BaseService 
{
  private UserRepository $userRepository;

  public function __construct(UserRepository $userRepository)
  {
    parent::__construct(); // Важно!
    $this->userRepository = $userRepository;
  }

  public function login(array $data): ?User
  {
    $sessionService = new SessionService();
    $validator = new LoginValidator($this->userRepository, $this->flash);

    if (!$validator->validate($data)) {
      return null;
    }

    $user = $this->userRepository->getUserByEmail($data['email']);

    if (!$user || !password_verify($data['password'], $user->getPassword())) {
      $this->flash->pushError('Неверный email или пароль');
      return null;
    }

    $sessionService->setUserSession($user);
    return $user;
  }
}
