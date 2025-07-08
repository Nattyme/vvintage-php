<?php
declare(strict_types=1);

namespace Vvintage\Services\Security;
use Vvintage\Models\User\User;
use Vvintage\Repositories\UserRepository;

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

    // $user = R::dispense('users');
    
    // Создаем бин в таблице адресов доставки
    $userDelivery = R::dispense('address');

    // $user->email = $postData['email'];
    // $user->role = 'user';

    // // Сохраняем пароль в зашифрованном виде функцией password_hash
    // $user->password = password_hash($postData['password'], PASSWORD_DEFAULT);

    // $userId = R::store($user);

    if ( is_int($userId) ) {
      // Сохраняем id пользователя в таблицу адресов доставки
      $userDelivery->user_id = $userId;
      R::store($userDelivery);

      $this->autoLoginNewUser($userId);
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

  private function autoLoginNewUser (int $userId): void
  {
    $_SESSION['logged_user'] = $user;
    $_SESSION['login'] = 1;
    $_SESSION['role'] = $user->role;
    $_SESSION['success'][] = ['title' => 'Регистрация завершена.', 'desc'=>'Заполните свой профиль для дальнейшего пользования сайтом'];
    header('Location: ' . HOST . 'profile-edit');
    exit();
  }

}