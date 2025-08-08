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
