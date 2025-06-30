<?php 
  if (isset($_SESSION['login']) && $_SESSION['login'] === 1 ) {
    // include ROOT . "views/_parts/_admin-panel.tpl";
  } 

  $isBlogPage = isset($data->uriModule) && $data->uriModule === 'blog' ? true : false;

?>

<header class="<?php echo (isset($_SESSION['login']) && $_SESSION['login'] === 1) ? 'header header--with-admin-panel' : 'header';?>">
	<div class="header__top <?php echo ($isBlogPage) ? 'header__top--blog' : '';?>">
		<div class="container">
			<div class="header__row">
        <?php if ($isBlogPage) : ?>
          <div class="blog-logo">
            <div class="blog-logo__title"><?php echo h($settings['site_title']);?></div>
            <span class="blog-logo__separator"></span>
            <div class="blog-logo__text">Блог о винтажной Франции </div>
          </div>
        <?php else : ?>
          <div class="header__logo">
            <a href="<?php echo HOST . 'main'; ?>" class="logo">
              <?php echo h($settings['site_title']);?>
            </a>
          </div>
        <?php endif; ?>
       
        
        <?php if ($isBlogPage) : ?>
          <ul class="menu">
            <li class="menu__item">
              <a href="<?php echo HOST . 'shop';?>">Перейти в Магазин</a>
            </li>
            <li class="menu__item">
              <a href="<?php echo HOST . 'contacts';?>">Написать нам</a>
            </li>
          </ul>
          <ul class="social-list">
            <svg class="icon icon--zen">
              <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#zen';?>"></use>
            </svg>
          </ul>
           
        <?php else : ?>
          <?php include ROOT . 'templates/_parts/nav/nav.tpl';?>
       
          <div class="header__cta">
            <div class="header__user flex-block">
              <div class="header__login">
                <?php if (!isset($_SESSION['login']) || $_SESSION['login'] !== 1) : ?>
                    <a href="<?php echo HOST . 'login';?>" class=""><span>
                      <svg class="icon icon--login">
                        <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#login';?>"></use>
                      </svg>
                    </span></a>
                <?php endif; ?>
              </div>
              
              <a href="<?php echo HOST . 'cart';?>" class="header__cart counter">
                <svg class="icon icon--cart">
                  <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#cart';?>"></use>
                </svg>
                <?php if (!empty($cartCount)) : ?>
                  <div class="counter__widget counter__widget--cart">
                    <span class="text-ellipsis"><?php echo h($cartCount); ?></span>
                  </div>
                <?php endif; ?>
              </a>
    
            </div>
          </div>
        <?php endif;?>

				<button class="mobile-nav-btn">
					<div class="nav-icon"></div>
				</button>
			</div>
		</div>
	</div>
  <?php if ($isBlogPage) : ?>
  <?php else : ?>
    <div class="header__nav">
      <div class="container catalog-dropdown__container">
        <nav class="nav" id="nav">
          <ul class="nav__list" role="tablist" id="nav__list"></ul>
        </nav>

        <div 
          class="catalog-dropdown__background" 
          role="none">
        </div>
      </div>
    </div>
  <?php endif; ?>
</header>

<!-- **** MOBILE ****/ -->
<div class="mobile-nav">
	<div class="container">
		<div class="mobile-nav__buttons-wrapper">
			<div class="mobile-nav__buttons">
				<button class="button button-primary text-big"><span>Вход</span></button>
				<button class="button button-primary-outline text-big"><span>Регистрация</span></button>
			</div>
		</div>
		<div class="mobile-nav__block-wrapper">
			<div class="mobile-nav__block">
				<div class="mobile-nav__title-wrapper">
					<h3 class="mobile-nav__title">Категории</h3>
				</div>
				<ul class="mobile-nav__list"></ul>
			</div>
		</div>
	</div>
</div>
