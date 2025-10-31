<div class="header__top-panel">
  <div class="container">
    <div class="header__row">

      <?php include ROOT . 'views/components/select/_select-lang.tpl';?>

      <?php if (!$isBlogPage) : ?>
        <div class="header__logo">
          <a href="<?php echo HOST . 'main'; ?>" class="logo">
            <?php echo h($settings['site_title']); ?>
          </a>
        </div>
      <?php endif;?>


      <!-- Вход/Выход -->
      <div class="header__auth">
        
        <?php if (isset($_SESSION['login']) && $_SESSION['login'] === 1 && $_SESSION['role'] !== 'admin') : ?>

          <a class="admin-panel__link admin-panel__link--avatar" href="<?php echo HOST; ?>profile" title="Перейти на страницу своего профиля">
              <?php if ( !empty($_SESSION['logged_user']['avatar_small']) && file_exists(ROOT . 'usercontent/avatars/' . $_SESSION['logged_user']['avatar_small'])) : ?>
                <img src="<?php echo HOST . 'usercontent/avatars/' . h($_SESSION['logged_user']['avatar_small']);?>" alt="Перейти на страницу своего профиля">
              <?php else : ?>
                <img src="<?php echo HOST; ?>usercontent/avatars/no-avatar.svg" alt="Аватарка" />
              <?php endif; ?>
          </a>

          <a href="<?php echo HOST . 'logout'; ?>">
              <svg class="icon icon--logout">
                <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#logout';?>"></use>
              </svg>
          </a>

        <?php elseif (isset($_SESSION['login']) && $_SESSION['login'] === 1 && $_SESSION['role'] === 'admin') : ?>
          <a href="<?php echo HOST . 'logout'; ?>">
              <svg class="icon icon--logout">
                <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#logout';?>"></use>
              </svg>
          </a>
        
        <?php else : ?>
          <a href="<?php echo HOST . 'login'; ?>">
            <svg class="icon icon--login">
              <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#login'; ?>"></use>
            </svg>
          </a>
          

        <?php endif; ?>
      </div>

    </div>
  </div>
</div>


