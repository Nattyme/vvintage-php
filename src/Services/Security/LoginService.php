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

  public function __construct(
    private UserRepository $userRepository,
    private LoginValidator $validator,
    private SessionService $sessionService
  )
  {
    parent::__construct(); // Важно!
  }

  public function login(array $data): ?User
  {
    if (!$this->validator->validate($data)) {
      return null;
    }

    $user = $this->userRepository->getUserByEmail($data['email']);

    TOFIX: // СООБЩЕНИЕ ДОЛЖЕН ВЫВОДИТЬ КОНТРОЛЛЕР!!!
    if (!$user || !password_verify($data['password'], $user->getPassword())) {
      $this->flash->pushError('Неверный email или пароль');
      return null;
    }

    $this->sessionService->setUserSession($user);
    return $user;
  }
}
