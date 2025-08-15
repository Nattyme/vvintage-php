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
