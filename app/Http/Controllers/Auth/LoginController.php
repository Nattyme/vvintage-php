<?php
declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Base\BaseController;
use Illuminate\View\View;

final class LoginController 
// final class LoginController extends BaseController
{

  public function __construct(
    // private LoginService $service,
    // private LoginValidator $validator,
    // protected FlashMessage $flash,
    // protected SessionService $sessionService,
    // protected CookieService $cookieService,
    // protected SeoService $seoService,
    // protected PageService $pageService,
    // private ProductService $productService,
    // private UserItemsListStore $userItemsListStore
  ) 
  {
    // parent::__construct($flash, $sessionService, $pageService, $seoService); // Важно!
  }

  public function index(): void
  {
    $this->renderForm();
    dd('hey');
    if (!isset($_POST['login'])) {
      return;
    }

    try {
      $this->validator->validate($_POST); // валидация , если ошибка - выбросит исключение

      $userModel = $this->service->login($_POST);
      $this->sessionService->setUserSession($userModel);

      $this->handleItemsMerge($userModel); // слияние гостевой корзины и избранного с данными в БД
      $this->renderGreetingMessage($userModel);

      $this->redirect('profile'); // редирект
    } 
    catch (\Exception $error) {
      $this->flash->pushError($error->getMessage());
      $this->redirect('login');
    }

  
  }

  public function renderForm (): View 
  {
     return view('layouts.auth-page', []);
  }


  private function handleItemsMerge(User $userModel): void
  {
    // Создаем модели корзины и избранного пользователя и отдельно гостя
    $guestModels = $this->createGuestModels();
    $userModels = $this->createUserModels();

    $mergeService = new UserItemsMergeService();

    $dataForSession = $mergeService->mergeAllAfterLogin( $userModel, $userModels,  $guestModels, $this->productService);
  

    // Обновляем сессию и очищаем куки
    foreach ($dataForSession as $key => $value) {
      $this->sessionService->updateLogggedUserSessionItemsList($key, $value);
      $this->cookieService->clear($key); 
    }
  }
  

  /**
   * Создаёт и возвращает модели корзины и избранного гостя + хранилище
   *
   * @return array{GuestItemsListStore, Cart, Favorites}
 */
  private function createGuestModels(): array
  {
    $store = new GuestItemsListStore(); // создаем хранидище гостя

    // Извлекаем данные из хранилища и создаем экземпляры моделей
    $cart = new Cart($store->load('cart')); 
    $fav = new Favorites($store->load('fav_list'));

    return ['store' => $store, 'cart' => $cart, 'fav' => $fav];
  }

  /**
   * Создаёт и возвращает модели корзины и избранного пользователя + хранилище
   *
   * @return array{UserItemsListStore, Cart, Favorites}
 */
  private function createUserModels(): array
  {
    $cart = new Cart($this->userItemsListStore->load('cart'));
    $fav = new Favorites($this->userItemsListStore->load('fav_list'));
    
    return ['store' => $this->userItemsListStore, 'cart' => $cart, 'fav' => $fav];
  }




  // private function renderForm(RouteData $routeData): void
  // {
  //   $pageTitle = "Вход на сайт";
  
  //   $currentLang =  $this->pageService->currentLang;
  //   $languages = $this->pageService->languages;

  //   $this->renderAuthLayout('form-login', [
  //     'pageTitle' => $pageTitle,
  //     'currentLang' => $currentLang,
  //     'languages' => $languages
  //   ]);
    
  // }

  private function renderGreetingMessage(User $userModel): void 
  {
    // Сообщение об успехе
    $userName = $userModel->getName() ?? '';
    
    if (trim($userName) !== '') {
      $this->flash->pushSuccess(h(__('login.success.username', ['%name%' => $userName], 'messages')));
    } else {
      $this->flash->pushSuccess(h(__('login.success', [], 'messages')));
    }
  }
}