<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Security;

/** Роутинг */
use Vvintage\Routing\RouteData;

/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;

/** Модели */
use Vvintage\Models\User\User;
use Vvintage\Models\Cart\Cart;
use Vvintage\Models\Favorites\Favorites;
/** Репозитории */
use Vvintage\Repositories\User\UserRepository;

/** Сервисы */
use Vvintage\Services\SEO\SeoService;
use Vvintage\Services\Cart\CartService;
use Vvintage\Services\Page\PageService;
use Vvintage\Services\Security\LoginService;
use Vvintage\Services\Product\ProductService;
use Vvintage\Services\Favorites\FavoritesService;
use Vvintage\Services\User\UserItemsMergeService;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Session\SessionService;
use Vvintage\Services\Cookie\CookieService;

/** Хранилища */
use Vvintage\Store\UserItemsList\GuestItemsListStore;
use Vvintage\Store\UserItemsList\UserItemsListStore;


use Vvintage\Services\Validation\LoginValidator;


final class LoginController extends BaseController
{
  private LoginService $service;
  private LoginValidator $validator;
  private UserRepository $userRepository;

  public function __construct(
    protected FlashMessage $flash,
    protected SessionService $sessionService,
    protected CookieService $cookieService,
    private SeoService $seoService,
    private PageService $pageService,
    private ProductService $productService
  ) 
  {
    parent::__construct($flash, $sessionService); // Важно!
    $this->service = new LoginService();
    $this->validator = new LoginValidator();
    $this->productService = $productService;
    $this->userRepository = new UserRepository();
  }

  public function index(RouteData $routeData): void
  {
    $this->setRouteData($routeData);
    if (!isset($_POST['login'])) {
      $this->renderForm($routeData);
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
    $store = new UserItemsListStore($this->userRepository);
    $cart = new Cart($store->load('cart'));
    $fav = new Favorites($store->load('fav_list'));
    
    return ['store' => $store, 'cart' => $cart, 'fav' => $fav];
  }



  private function renderForm(RouteData $routeData): void
  {
    // Название страницы
    $page = $this->pageService->getPageBySlug($routeData->uriModule);
    $pageModel = $this->pageService->getPageModelBySlug( $routeData->uriModule );
    $seo = $this->seoService->getSeoForPage('profile-edit', $pageModel);

    $pageTitle = "Вход на сайт";
  
    $currentLang =  $this->pageService->currentLang;
    $languages = $this->pageService->languages;

    $this->renderAuthLayout('form-login', [
      'page' => $page,
      'seo' => $seo,
      'pageTitle' => $pageTitle,
      'currentLang' => $currentLang,
      'languages' => $languages
    ]);
    
  }

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
