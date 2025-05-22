<?php 
  if(isset($_SESSION['logged_user']) && trim($_SESSION['logged_user']) !== '') {
    include ROOT . "templates/_parts/_admin-panel.tpl";
  } 
?>

<header class="<?php echo (isset($_SESSION['logged_user']) && trim($_SESSION['logged_user']) !== '') ? 'header header--with-admin-panel' : 'header';?>">
	<div class="header__top">
		<div class="container">
			<div class="header__row">
				<div class="header__logo">
					<a href="<?php echo HOST . 'main'; ?>" class="logo">
						VVintage
					</a>
				</div>

				<div class="header__cta">
					<div class="header__user flex-block">
						<div class="header__login">
              <?php if (!isset($_SESSION['logged_user']) || trim($_SESSION['logged_user']) === '') : ?>
							    <a href="<?php echo HOST . 'login';?>" class=""><span>
                    <svg class="icon icon--profile">
									    <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#profile';?>"></use>
								    </svg>
                  </span></a>
              <?php endif; ?>
						</div>
						
            <a href="<?php echo HOST . 'cart';?>" class="header__cart counter">
              <svg class="icon icon--shopping-bag">
                <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#shopping-bag';?>"></use>
              </svg>
               <?php if (!empty($cartCount)) : ?>
                <div class="counter__widget counter__widget--cart">
                  <span class="text-ellipsis"><?php echo $cartCount; ?></span>
                </div>
              <?php endif; ?>
            </a>
		
						<!-- <div class="header__cart">
							<a href="<?php echo HOST . 'cart';?>" class="cart-widget">
								<svg class="icon icon--shopping-bag">
									<use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#shopping-bag';?>"></use>
								</svg>
								<div class="cart-widget__counter">
                    <?php if (!empty($cartCount)) : ?>
									    <div class="counter">
                        <span class="text-ellipsis"><?php echo $cartCount; ?></span>
                   
									    </div>
                    <?php endif; ?>
								</div>
							</a>
						</div> -->
					</div>
				</div>

				<button class="mobile-nav-btn">
					<div class="nav-icon"></div>
				</button>
			</div>
		</div>
	</div>

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
