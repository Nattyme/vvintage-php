<div class="header__top-panel">
  <div class="container">
    <div class="header__row">
      
      <!-- Язык -->
      <!-- <div class="header__lang">
        <form id="language-selector" method="GET">
          <select id="language-select" name="lang" class="admin-form__input">
            <?php foreach ($languages as $code => $label): ?>
              <option value="<?php echo h($code) ?>" <?php echo ($code === $currentLang) ? 'selected' : '';?>>
                <?php echo h($label);?>
              </option>
            <?php endforeach; ?>
          </select>
        </form>
        
      </div> -->
<!-- 
      <div class="header__lang" data-custom-select>
        <form id="language-selector" method="GET">
          <ul class="custom-select__list" role="listbox">
            <?php foreach ($languages as $code => $label) : ?>
              <li class="custom-select__item" data-value="<?php echo h($code) ?>" role="option">
                <span class="custom-select__icon">
                  <img src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#flag-' . h($code); ?>" alt="<?php echo h($code) ?>">
                </span>
                <div class="custom-select__text">
                  <?php echo h($label) ?>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
        </form>
        
      </div> -->

      <div class="header__lang custom-select" data-custom-select>
        <form id="language-selector" method="GET" data-custom-select-form>
          <input type="hidden" name="lang" id="selected-language" value="<?php echo h($currentLang ?? '') ?>" data-custom-select-input>
          
          <div class="custom-select__selected custom-select__item" tabindex="0" aria-haspopup="listbox" aria-expanded="false" data-custom-select-selected>
                <?php 
                  // Показываем текущий выбранный язык
                  if (isset($currentLang) && isset($languages[$currentLang])) {
                    $code = h($currentLang);
                    $label = h($languages[$currentLang]);
                    echo "<span class='custom-select__icon'><img src='" . HOST . "static/img/svgsprite/stack/svg/sprite.stack.svg#flag-$code' alt='$code'></span>";
                    echo "<div class='custom-select__text'>$label</div>";
                  } else {
                    echo "Выберите язык";
                  }
                ?>
          </div>
              
          <ul class="custom-select__list" role="listbox" tabindex="-1">
            <?php foreach ($languages as $code => $label) : 
              $isActive = ($code === $currentLang) ? 'custom-select__item--active' : '';
            ?>

              <?php if (! $isActive ) : ?>
                <li 
                  class="custom-select__item <?=$isActive;?>" 
                  role="option" 
                  aria-selected="<?= $code === $currentLang ? 'true' : 'false' ?>"
                  data-value="<?php echo h($code) ?>">
                      <span class="custom-select__icon">
                        <img src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#flag-' . h($code); ?>" alt="<?php echo h($code) ?>">
                      </span>
                      <span class="custom-select__text">
                        <?php echo h($label) ?>
                      </span>
                </li>
              <?php endif;?>
            <?php endforeach; ?>
          </ul>
        </form>
        <script>
          const select = document.querySelector('[data-custom-select]');
          const selected = select.querySelector('[data-custom-select-selected]');
 
          const form = select.querySelector('[data-custom-select-form]');
          const input = form.querySelector('[data-custom-select-input]');
          const selectList = form.querySelector('ul');
        
          //  <div class="custom-select__selected" tabindex="0" aria-haspopup="listbox" aria-expanded="false" data-custom-select-selected>
          selectList.setAttribute('hidden', true);

          selected.addEventListener('click', (e) => {
            selectList.removeAttribute('hidden', true);
            selected.setAttribute('aria-expanded', true);
          });

          selectList.addEventListener('click', (e) => {
            e.stopPropagation();
            let lang = e.target.closest('li').dataset.value;
            input.value = lang; 
            selectList.setAttribute('hidden', true);
            selected.setAttribute('aria-expanded', false);
            form.submit();
          });

          document.addEventListener('click', (e) => {
            if (!select.contains(e.target)) {
              selectList.hidden = true;
            }
          });
              
      
        </script>
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
