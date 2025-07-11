<?php
declare(strict_types=1);

namespace Vvintage\Services\Favorites;

use RedBeanPHP\R;
use Vvintage\Models\Favorites\Favorites;
use Vvintage\Models\User\User;
use Vvintage\Services\Messages\FlashMessage;


final class FavoritesService 
{
    private FlashMessage $notes;

    public function __construct(FlashMessage $notes)
    {
        $this->notes = $notes;
    }

    /**
      * Слияние избранного (очистка куки, сохранение нового избранного в БД и сессию)
      * @param Favorites $userFavModel модель избранного пользователя
      * @param Favorites $guestFavModel модель избранного гостя
    */
    public function mergeFavAfterLogin(Favorites $userFavModel, Favorites $guestFavModel): void
    {
      $userFavProducts = $userFavModel->getItems();
      $guestFavProducts = $guestFavModel->getItems();

      foreach ($guestFavProducts as $itemId => $quantity) {
          if (!isset( $userFavProducts[$itemId]) ) {
            $userFavModel->addFavItem($itemId);
          }
      }

      // Очищаем cookies
      $this->clearGuestCookies();

      // Обновляем сессию
      $_SESSION['logged_user']['fav_list'] = $userFavModel->getItems();
      $_SESSION['fav_list'] =  $userFavModel->getItems();

      // Передаем приветствие в сессию
      $this->setWelcomeMessage();
    }

    private function clearGuestCookies()
    {
      if (isset($_COOKIE['fav_list'])) {
             setcookie('fav_list', '', time() - 3600, '/');
      }

    }

    private function setWelcomeMessage()
    {
      if (isset($_SESSION['logged_user']['name']) && trim($_SESSION['logged_user']['name']) !== '') {
        $this->notes->pushSuccess('Здравствуйте, ' . htmlspecialchars($_SESSION['logged_user']['name']), 'Вы успешно вошли на сайт. Рады снова видеть вас');
      } else {
        $this->notes->pushSuccess('Здравствуйте!', 'Вы успешно вошли на сайт. Рады снова видеть вас');
      }  
    }

}
