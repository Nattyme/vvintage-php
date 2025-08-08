<header class="<?php echo (isset($_SESSION['login']) && $_SESSION['login'] === 1) ? 'header header--with-admin-panel' : 'header'; ?>">

  <!-- 🔝 Верхняя служебная панель -->
  <div class="header__top-panel">
    <div class="container">
      <div class="header__row">
        
        <!-- Язык -->
        <div class="header__lang">
          <form id="language-selector" method="GET">
            <select id="language-select" name="lang" class="admin-form__input">
              <?php foreach ($languages as $code => $label): ?>
                <option value="<?php echo h($code) ?>" <?php echo ($code === $currentLang) ? 'selected' : '';?>>
                  <?php echo h($label);?>
                </option>
              <?php endforeach; ?>
            </select>
          </form>
        </div>

        <!-- 👤 Вход/Выход -->
        <div class="header__auth">
          <?php if (!isset($_SESSION['login']) || $_SESSION['login'] !== 1) : ?>
            <a href="<?php echo HOST . 'login'; ?>">
              <svg class="icon icon--login">
                <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#login'; ?>"></use>
              </svg>
            </a>
          <?php else : ?>
            <a href="<?php echo HOST . 'logout'; ?>">Выход</a>
          <?php endif; ?>
        </div>

      </div>
    </div>
  </div>

  <!-- 🌿 Основной хедер -->
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
          <div class="header__logo">
            <a href="<?php echo HOST . 'main'; ?>" class="logo">
              <?php echo h($settings['site_title']); ?>
            </a>
          </div>
        <?php endif; ?>

        <!-- Навигация -->
        <?php if ($isBlogPage) : ?>
          <ul class="menu">
            <li class="menu__item"><a href="<?php echo HOST . 'shop'; ?>">
                <?php echo h(__('blog.backto.shop', [], 'blog'));?>
            </a></li>
            <li class="menu__item"><a href="<?php echo HOST . 'contacts'; ?>">
              <?php echo h(__('blog.cta.contact.us', [], 'blog'));?>
            </a></li>
          </ul>
          <ul class="social-list">
            <svg class="icon icon--zen">
              <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#zen'; ?>"></use>
            </svg>
          </ul>
        <?php else : ?>
          <?php include ROOT . 'templates/_parts/nav/nav.tpl'; ?>

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
              <?php if (!empty($cartCount)) : ?>
                <div class="counter__widget counter__widget--cart">
                  <span class="text-ellipsis"><?php echo h($cartCount); ?></span>
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

  <!-- Категории -->
  <?php if (!$isBlogPage) : ?>
    <div class="header__nav">
      <div class="container catalog-dropdown__container">
        <nav class="nav" id="nav">
          <ul class="nav__list" role="tablist" id="nav__list"></ul>
        </nav>
        <div class="catalog-dropdown__background" role="none"></div>
      </div>
    </div>
  <?php endif; ?>
</header>

