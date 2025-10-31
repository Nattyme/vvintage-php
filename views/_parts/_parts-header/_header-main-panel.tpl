<div class="header__main-panel <?php echo ($isBlogPage) ? 'header__top--blog' : ''; ?>">
  <div class="container">
    <div class="header__row">

      <!-- Логотип -->
      <?php if ($isBlogPage) : ?>
        <div class="blog-logo">
          <div class="blog-logo__title"><?php echo h($settings['site_title']); ?></div>
          <span class="blog-logo__separator"></span>
          <div class="blog-logo__text">Блог о винтажной Франции</div>
        </div>
      <?php else : ?>
        <!-- <div class="header__logo">
          <a href="<?php echo HOST . 'main'; ?>" class="logo">
            <?php echo h($settings['site_title']); ?>
          </a>
        </div> -->
      <?php endif; ?>

      <!-- Навигация -->
      <?php if ($isBlogPage) : ?>
        <div class="header__tools">

          <ul class="menu">
            <li class="menu__item"><a href="<?php echo HOST . 'shop'; ?>">
                <?php echo h(__('blog.backto.shop', [], 'blog'));?>
            </a></li>
            <li class="menu__item"><a href="<?php echo HOST . 'contacts'; ?>">
              <?php echo h(__('blog.cta.contact.us', [], 'blog'));?>
            </a></li>
          </ul>
            <ul class="social-list">
              <li>
                <a href="">
                    <svg class="icon icon--zen">
                      <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#zen'; ?>"></use>
                    </svg>
                </a>
              </li>
            
            </ul>
        </div>
      
      <?php else : ?>
        <?php include ROOT . 'views/_parts/nav/nav.tpl'; ?>

        <!-- Иконки: избранное + корзина -->
        <div class="header__icons">
          <a href="<?php echo HOST . 'favorites'; ?>" class="header__favorite">
            <svg class="icon icon--favorite">
              <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#favorite'; ?>"></use>
            </svg>
          </a>
          <a href="<?php echo HOST . 'cart'; ?>" class="header__cart counter">
            <svg class="icon icon--cart">
              <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#cart'; ?>"></use>
            </svg>
            <?php if (!empty($_SESSION['cart'])) : ?>
              <div class="counter__widget counter__widget--cart">
                <span class="text-ellipsis"><?php echo h(count($_SESSION['cart'])); ?></span>
              </div>
            <?php elseif (!empty($_COOKIE['cart']) && h(count(json_decode($_COOKIE['cart'] ?? '[]', true))) > 0) : ?>
              <div class="counter__widget counter__widget--cart">
                <span class="text-ellipsis"><?php echo h(count(json_decode($_COOKIE['cart'] ?? '[]', true))); ?></span>
              </div>
            <?php endif; ?>
          </a>
        </div>
      <?php endif; ?>

      <!-- Бургер -->
      <button class="mobile-nav-btn"><div class="nav-icon"></div></button>

    </div>
  </div>
</div>

