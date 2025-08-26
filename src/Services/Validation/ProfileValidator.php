<?php
declare(strict_types=1);

namespace Vvintage\Services\Validation;

use Vvintage\Services\Auth\SessionManager;
use Vvintage\Repositories\User\UserRepository;
use Vvintage\Services\Base\BaseService;

final class ProfileValidator extends BaseService
{
  public function __constuct()
  {
    parent::__construct(); // Важно!
  }
  public function validateLogin()
  {
     // Проверка на то, что юзер залогинен
    if( isset($_SESSION['login']) && $_SESSION['login'] === 1) {
      // Юзер залогинен. Проверка на роль - пользователь или админ
      if( $_SESSION['logged_user']['role'] === 'user') {
        // Это обычный пользователь
        // Загружаем пользователя
        $user = R::load('users', $_SESSION['logged_user']['id']);

        //Загружаем адрес доставки
        $userDelivery = R::findOne('address', ' user_id = ? ', [$_SESSION['logged_user']['id']]);
    
        updateUserAndGoToProfile($user);  //Обновляем данные пользователя
        updateUserDeliveryAndGoToProfile($userDelivery); //Обновляем данные доставки  пользователя
      } else if ( $_SESSION['logged_user']['role'] === 'admin') {
  
        // Это администратор сайта. Делаем проверку на доп парам - ID пользователя для редактирования
        if ( isset($uriGet) && $uriGet !== $_SESSION['logged_user']['id']) {
          //Редакт. чужого профиля. 
          $user = R::load('users', intval($uriGet) ); // Загружаем данные о профиле
          //Обновляем данные пользователя
          updateUserAndGoToProfile($user);
        } else {
          // Редактирование своего профиля
          $user = R::load('users', $_SESSION['logged_user']['id']);
      
          //Загружаем адрес доставки
          $userDelivery = R::findOne('address', ' user_id = ? ', [$_SESSION['logged_user']['id']]);

          updateUserAndGoToProfile($user);  //Обновляем данные пользователя
          updateUserDeliveryAndGoToProfile($userDelivery); //Обновляем данные доставки  пользователя
        }
      }
    } else {
      header('Location: ' . HOST . 'login');
      exit();
    }

  }
}