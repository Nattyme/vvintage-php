<?php
declare(strict_types=1);

namespace Vvintage\Services\Security;
use Vvintage\Models\User\User;
use Vvintage\Repositories\UserRepository;
use Vvintage\Services\Auth\SessionManager;

use RedBeanPHP\R;

final class RegistrationService
{
  public function createNewUser (array $postData):void
  {
    $userRepository = new UserRepository();

    /**
     * @var User|null
    */
    $user = $userRepository->createUser($postData);
    $userId = $user->getId();

    if ( is_int($userId) ) {
      // Создаем адрес пользователи в таблицу адресов доставки и сохраняем Id адреса 
      $addressId = $userRepository->createAddress( $userId );

      // Обновляем пользователя, добавляя address_id
      $userRepository->updateUserAddressId( $userId, $addressId );

      // Автологин 
      $this->autoLoginNewUser($user);
    }
  }

  public function isEmailFree (string $emailData): bool
  {
    $email = R::count('users', 'email = ?', array($emailData));
    return  $email  > 0 ? false : true;
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