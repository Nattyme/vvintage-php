<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Security;


/** Модели */
use Vvintage\Models\User\User;
use Vvintage\Models\User\GuestUser;
use Vvintage\Models\Cart\Cart;
use Vvintage\Models\Favorites\Favorites;

use Vvintage\Services\Auth\SessionManager;

/** Сервисы */
use Vvintage\Services\Cart\CartService;
use Vvintage\Services\Favorites\FavoritesService;


// use Vvintage\Services\Security\PasswordResetService;
use Vvintage\Repositories\UserRepository;
use Vvintage\Repositories\ProductRepository;

// use Vvintage\Services\Validation\PasswordResetValidator;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Routing\RouteData;

/** Store */
use Vvintage\Store\UserItemsList\GuestItemsListStore;
use Vvintage\Store\UserItemsList\UserItemsListStore;

/** Контролеры */
use Vvintage\Controllers\Cart\CartController;
use Vvintage\Services\Validation\LoginValidator;



final class LoginController
{
  private UserRepository $userRepository;
  private ProductRepository $productRepository;
  private FlashMessage $notes;

  public function __construct(UserRepository $userRepository, ProductRepository $productRepository, FlashMessage $notes) 
  {
    $this->userRepository = $userRepository;
    $this->productRepository = $productRepository;
    $this->notes = $notes;
  }


  function index(RouteData $routeData)
  {
    //1. Проверяем массив POST
    if (isset($_POST['login'])) {
      $validator = new LoginValidator($this->userRepository, $this->notes);

      if ( $validator->validate( $_POST )) {
        // Ищем нужного пользователя в базе данных
        $userModel = $this->userRepository->findUserByEmail($_POST['email']);

        
        if (!$userModel) {
          $this->notes->pushError('Неверный email');
        }

        
        if (empty($_SESSION['errors'])) {
            /** Получаем модель с корзиной гостя 
              * @var UserInterface $guestCartData 
            */
            $guestCartStore = new GuestItemsListStore();
            $guestFavStore = new GuestItemsListStore();

            $guestCart = $guestCartStore->load('cart');
            $guestFav = $guestFavStore->load('fav_list');

            $guestCartModel = new Cart( $guestCart);
            $guestFavModel = new Favorites($guestFav);

            $cartService = new CartService(
              $userModel, $guestCartModel, $guestCartModel->getItems(), $guestCartStore, $this->productRepository, $this->notes
            );
            $favService = new FavoritesService(
              $userModel, $guestFavModel, $guestFavModel->getItems(), $guestFavStore, $this->productRepository, $this->notes
            );

            // Проверить пароль
            if (password_verify($_POST['password'], $userModel->getPassword())) {
              $isLoggedIn = SessionManager::setUserSession($userModel);
          
              /** Получаем корзину пользователя из БД
               * @var UserInterface  $userCartData
              */
              $userCartStore = new UserItemsListStore($this->userRepository); 
              $userFavStore = new UserItemsListStore($this->userRepository);
              
              $userCart = $userCartStore->load('cart');
              $userFav =  $userFavStore->load('fav');

              // Создаем модель корзины пользователя В АБСТРАКЦИЮ
              $cartModel = new Cart( $userCart);
              $favModel = new Favorites(  $userFav );

              // Выполняем слияние cart и fav через Service МЕТОЖ УЖЕ В АБСТРАКЦИИ ПРОВЕРИТЬ 
              $cartService->mergeItemsListAfterLogin($cartModel, $guestCartModel);
              $favService->mergeItemsListAfterLogin($favModel, $guestFavModel);

              $mergedCart = $cartModel->getItems();
              $mergedFav = $favModel->getItems();

              // Сохраняем в БД
              $this->userRepository->saveUserItemsList('cart', $userModel, $mergedCart);
              $this->userRepository->saveUserItemsList('fav_list', $userModel, $mergedFav);

              
              if (isset($_SESSION['logged_user']['name']) && trim($_SESSION['logged_user']['name']) !== '') {
        
                $this->notes->pushSuccess( h(__(
                  'login.success.username', 
                  ['%name%' => $_SESSION['logged_user']['name']] , 
                  'messages'
                )));
                // $this->notes->pushSuccess('Здравствуйте, ' . h($_SESSION['logged_user']['name']), 'Вы успешно вошли на сайт. Рады снова видеть вас');
        
              } else {
                $this->notes->pushSuccess(h(__('login.success', [], 'messages')));
              }  
              

              header('Location: ' . HOST . 'profile');
              exit();

            } else {
              // Пароль не верен
              $this->notes->pushError('Неверный пароль');
            }
        }
          
        // Показываем страницу
        $this->renderForm($routeData);

      }
    }

    // Показываем страницу
    $this->renderForm($routeData);
  }

  
  private function renderForm (RouteData $routeData): void
  {
    $pageTitle = "Вход на сайт";
    $pageClass = "authorization-page";

    //Сохраняем код ниже в буфер
    ob_start();
    include ROOT . 'views/login/form-login.tpl';
    //Записываем вывод из буфера в пепеменную
    $content = ob_get_contents();
    //Окончание буфера, очищаем вывод
    ob_end_clean();

    include ROOT . "templates/_page-parts/_head.tpl";
    include ROOT . "views/login/login-page.tpl";
    include ROOT . "views/_page-parts/_foot.tpl";
  }
}