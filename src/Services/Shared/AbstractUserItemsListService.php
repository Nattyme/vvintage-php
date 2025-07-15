<?php
declare(strict_types=1);

namespace Vvintage\Services\Shared;

abstract class AbstractUserItemsListService
{
    // private FlashMessage $notes;

    // public function __construct(FlashMessage $notes)
    // {
    //     $this->notes = $notes;
    // }

    // private function clearGuestCookies()
    // {
    //   if (isset($_COOKIE[$this->getSessionKey()])) {
    //          setcookie($this->getSessionKey(), '', time() - 3600, '/');
    //   }

    //   // if (isset($_COOKIE['fav_list'])) {
    //   //     setcookie('fav_list', '', time() - 3600, '/');
    //   // }
    // }

    // private function setWelcomeMessage()
    // {
    //   if (isset($_SESSION['logged_user']['name']) && trim($_SESSION['logged_user']['name']) !== '') {
    //     $this->notes->pushSuccess('Здравствуйте, ' . htmlspecialchars($_SESSION['logged_user']['name']), 'Вы успешно вошли на сайт. Рады снова видеть вас');
    //   } else {
    //     $this->notes->pushSuccess('Здравствуйте!', 'Вы успешно вошли на сайт. Рады снова видеть вас');
    //   }  
    // }



    // abstract public function getSessionKey(): string; // обязательно для наследников
}
