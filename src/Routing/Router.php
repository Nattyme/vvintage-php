<?php
  namespace Vvintage\Routing;
  use Vvintage\Routing\RouteData; 

  class Router {
    public static function route(RouteData $data) {
      /*****************************
            РОУТЕР
      *****************************/
      switch ($data->module) {
        case '':
          require ROOT . 'modules/main/index.php';
          break;


        // ::::::::::::: USERS :::::::::::::::::::
        case 'login':
          require ROOT . 'modules/login/login.php';
          break;

        case 'registration':
          require ROOT . 'modules/login/registration.php';
          break;

        case 'logout':
          require ROOT . 'modules/login/logout.php';
          break;

        case 'lost-password':
          require ROOT . 'modules/login/lost-password.php';
          break;

        case 'set-new-password':
          require ROOT . 'modules/login/set-new-password.php';
          break;

        case 'profile':
          require ROOT . 'modules/profile/profile.php';
          break;

        case 'profile-edit':
          require ROOT . 'modules/profile/profile-edit.php';
          break;

        case 'profile-order':
          require ROOT . 'modules/profile/profile-order.php';
          break;


        // ::::::::::::: SHOP :::::::::::::::::::
        case 'shop':
          if ( isset($uriGet) && $uriGet === 'cat' && !empty($uriGetParam) ) {
            require ROOT . 'modules/shop/categories.php';
          } else if ( isset($uriGet) && $uriGet === 'brand' && !empty($uriGetParam) ) {
            require ROOT . 'modules/shop/brands.php';
          } else if ( isset($uriGet) && $uriGet === 'subcat' && !empty($uriGetParam)) {
            require ROOT . 'modules/shop/subcat.php';
          } else if ( isset($uriGet) && $uriGet !== 'cat' && $uriGet !== 'subcat') {
            require ROOT . 'Models/shop/Product.php';
            // require ROOT . 'modules/shop/product.php';
          } else {
            require ROOT . 'modules/shop/catalog.php';
          }
        break;


        // ::::::::::::: BLOG :::::::::::::::::::
        case 'blog':
          if ( isset($uriGet) && $uriGet === 'cat' && !empty($uriGetParam) ) {
            require ROOT . 'modules/blog/categories.php';
          } else if ( isset($uriGet) ) {
            require ROOT . 'modules/blog/single.php';
          } else {
            require ROOT . 'modules/blog/all.php';
          }
        break;
        case 'add-comment':
          require ROOT . 'modules/blog/add-comment.php';
          break;


        // ::::::::::::: CART :::::::::::::::::::
        case 'cart':
          require ROOT . 'modules/cart/cart.php';
          break;
          
        case 'addtocart':
          require ROOT . 'modules/cart/addtocart.php';
          break;
        
        case 'removefromcart':
          require ROOT . 'modules/cart/remove.php';
          break;


        // ::::::::::::: ORDERS :::::::::::::::::::
        case 'neworder':
          require ROOT . 'modules/orders/new.php';
          break;

        case 'ordercreated':
          require ROOT . 'modules/orders/created.php';
          break;


        // ::::::::::::: OTHER :::::::::::::::::::
        case 'main':
          require ROOT . 'modules/main/index.php';
          break;

        case 'contacts':
          require ROOT . 'modules/contacts/index.php';
          break;

        case 'about':
          require ROOT . 'modules/about/index.php';
          break;
      }
      /*****************************
                  // РОУТЕР 
      *****************************/
    }
  }