<?php
declare(strict_types=1);

namespace Vvintage\Public\Services\Security;

use Vvintage\Models\User\User;
use Vvintage\Public\Services\User\UserService;


final class PasswordSetNewService
{
  private UserService $userService;

  public function __construct () {
    $this->userService = new UserService();
  }

  
  public function handleRecoveryLinkPassing(string $email, string $resetCode): void
  {
      $userModel = $this->userService->findUserByEmail($email);
      if (!$userModel) throw new \Exception('Пользователь с таким email не найден');
      
      $valid = $this->isValidRecoveryCode($email, $resetCode);
      if(!$valid) throw new \Exception('Неверный или просроченный код восстановления');
  }

  public function handleNewPassSetting(string $email, string $resetCode, string $password): void 
  {
      $userModel = $this->userService->findUserByEmail($email);
      if (!$userModel) throw new \Exception('Пользователь с таким email не найден');

      if ($this->userService->findBlockedUserByEmail($email)) throw new \Exception('Ошибка регистрации');
    

      $isValidCode = $this->isValidRecoveryCode($email, $resetCode);
      if (!$isValidCode) throw new \Exception('Неверный или просроченный код восстановления. Попробуйте ещё раз.');

      $this->userService->updateUserPassword($userModel, $password);
  }

  /**
   * Метод сохраняет id адреса в поле теблицы User
  */
  public function updateRecoveryCodeByEmail (string $email, string $recoveryCode): ?int
  {
    $userModel = $this->userService->findUserByEmail($email);
    
    if (!$userModel) return false; // если пользователь не найден
    
    return $this->userService->setRecoveryCode($userModel, $recoveryCode);   // Сохраняем recovery code в таблицу User
  }

  public function isValidRecoveryCode(string $email, string $code): bool
  {
    $userModel = $this->userService->findUserByEmail($email);

    if (!$userModel) return false;

    // Получим recovery code из БД
    $recoveryCodeDB = $this->userService->getRecoveryCode($userModel);

    return $recoveryCodeDB === $code;
  }

  public function updateUserPassword(string $password, string $email)
  {
    $userModel = $this->userService->findUserByEmail($email);

    // Смена пароля. Сохраняем пароль в зашифрованном виде функцией password_hash
    $this->userService->updateUserPassword($userModel, $password);

    // Сбрасываем recovery code
    $this->userService->setRecoveryCode ($userModel, '');
  }

}
