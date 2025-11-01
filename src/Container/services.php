<?php
declare(strict_types=1);


use Vvintage\Services\Locale\LocaleService;
 use Vvintage\Services\SEO\SeoService;
  use Vvintage\Services\Session\SessionService;
  use Vvintage\Services\Navigation\NavigationService;
  use Vvintage\Services\Messages\FlashMessage;
  use Vvintage\Services\Messages\MessageService;

  use Vvintage\Services\Page\Breadcrumbs;
  use Vvintage\Services\Page\PageService;
  use Vvintage\Services\Shared\PaginationService;


  use Vvintage\Services\User\UserItemsMergeService;
  use Vvintage\Services\User\UserService;
  use Vvintage\Services\Cart\CartService;
  use Vvintage\Services\Favorites\FavoritesService;
  use Vvintage\Services\Address\AddressService;
  
  use Vvintage\Repositories\Category\CategoryRepository;
  use Vvintage\Services\Category\CategoryService;

  use Vvintage\Services\Blog\BlogService;
  use Vvintage\Services\Post\PostService;
  use Vvintage\Repositories\Post\PostTranslationRepository;
  use Vvintage\Repositories\PostCategory\PostCategoryTranslationRepository;
  use Vvintage\Services\PostCategory\PostCategoryService;

  use Vvintage\Services\Product\ProductService;
  use Vvintage\Services\Product\ProductImageService;
  use Vvintage\Services\Brand\BrandService;
  use Vvintage\Services\Admin\Product\AdminProductImageService;
  use Vvintage\Services\Order\OrderService;
 

  use Vvintage\Services\Security\PasswordSetNewService;
  use Vvintage\Services\Security\RegistrationService;
  use Vvintage\Services\Security\PasswordResetService;
  use Vvintage\Services\Security\LoginService;
  use Vvintage\Services\Validation\RegistrationValidator;
   use Vvintage\Services\Validation\NewOrderValidator;
  use Vvintage\Services\Validation\ProfileValidator;
  use Vvintage\Services\Validation\LoginValidator;
  use Vvintage\Services\Validation\PasswordResetValidator;

  use Vvintage\Services\AdminPanel\AdminPanelService;
  use Vvintage\Services\Admin\Brand\AdminBrandService;
  use Vvintage\Services\Admin\Validation\AdminBrandValidator;
  use Vvintage\Services\Admin\Category\AdminCategoryService;
  use Vvintage\Services\Admin\Validation\AdminCategoryValidator;
  use Vvintage\Services\Admin\Messages\AdminMessageService;
  use Vvintage\Services\Admin\Order\AdminOrderService;
  use Vvintage\Services\Admin\Post\AdminPostService;
  use Vvintage\Services\Admin\PostCategory\AdminPostCategoryService;
  use Vvintage\Services\Admin\Validation\AdminPostCategoryValidator;
  use Vvintage\Services\Admin\Product\AdminProductService;
  use Vvintage\Services\Admin\User\AdminUserService;
  use Vvintage\Services\Admin\AdminStatsService;


// Пример
$container = new Container();

// Services
$container->set(LocaleService::class, fn() => new LocaleService());
$container->set(FlashMessage::class, fn() => new FlashMessage());
$container->set(SeoService::class, fn($c) => new SeoService(
    $c->get(LocaleService::class),
    $c->get(FlashMessage::class)
));

return $container;
