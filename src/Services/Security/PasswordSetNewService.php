<?php
declare(strict_types=1);

namespace Vvintage\Services\Security;
use Vvintage\Models\User\User;
use Vvintage\Repositories\User\UserRepository;

use RedBeanPHP\R;

final class PasswordSetNewService 
{
  private UserRepository $userRepository;

  public function __construct (UserRepository $userRepository) {
    $this->userRepository = $userRepository;
  }

  public function findUserByEmail(string $userEmail): User
  {
    $userModel = $this->userRepository->findUserByEmail($userEmail);

    return $userModel;
  }

  /**
   * Метод сохраняет id адреса в поле теблицы User
  */
  public function updateRecoveryCodeByEmail (string $email, string $recoveryCode): bool {
    $userModel = $this->userRepository->findUserByEmail($email);
    
    if (!$userModel) {
        return false;
    }

    // Сохраняем recovery code в таблицу User
    $this->userRepository->setRecoveryCode($userModel, $recoveryCode);
    return true;
  }

  public function isValidRecoveryCode(string $email, string $code): bool
  {
    $userModel = $this->userRepository->findUserByEmail($email);

    if (!$userModel) {
        return false;
    }

    // Получим recovery code из БД
    $recoveryCodeDB = $this->userRepository->getRecoveryCode($userModel);

    return $recoveryCodeDB === $code;
  }

  public function updateUserPassword(string $password, string $email)
  {
    $userModel = $this->userRepository->findUserByEmail($email);

    // Смена пароля. Сохраняем пароль в зашифрованном виде функцией password_hash
    $this->userRepository->updateUserPassword($userModel, $password);

    // Сбрасываем recovery code
    $this->userRepository->setRecoveryCode ($userModel, '');
  }

}
