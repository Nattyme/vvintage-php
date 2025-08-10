<header class="authorization-page__header">
  <a class="authorization-page__link" href="<?php echo HOST; ?>">
    <h2 class="authorization-page__header-title">vvintage.ru</h2>
    <p class="authorization-page__header-subtitle">
      <?php echo h(__('auth.page.slogan', [], 'auth')) ;?>
    </p>
  </a>
  <div class="header__lang authorization-page__lang custom-select" data-custom-select>
    <form id="language-selector" method="GET" data-custom-select-form>

      <input type="hidden" name="lang" id="selected-language" value="<?php echo h($currentLang ?? '') ?>" data-custom-select-input>
      
      <div class="custom-select__selected custom-select__item" tabindex="0" aria-haspopup="listbox" aria-expanded="false" data-custom-select-selected>
            <?php 
              // Показываем текущий выбранный язык
              if (isset($this->currentLang) && isset($this->languages[$this->currentLang])) {
                $code = h($this->currentLang);
                $label = h($this->languages[$this->currentLang]);
                echo "<span class='custom-select__icon'><img src='" . HOST . "static/img/svgsprite/stack/svg/sprite.stack.svg#flag-$code' alt='$code'></span>";
              } else {
                echo "Выберите язык";
              }
            ?>
            <svg class="icon icon--arrow-down">

            </svg>
      </div>
          
      <ul class="custom-select__list" role="listbox" tabindex="-1">
        <?php foreach ($this->languages as $code => $label) : 
          $isActive = ($code === $this->currentLang) ? 'custom-select__item--active' : '';
        ?>

          <?php if (! $isActive ) : ?>
            <li 
              class="custom-select__item <?=$isActive;?>" 
              role="option" 
              aria-selected="<?= $code === $this->currentLang ? 'true' : 'false' ?>"
              data-value="<?php echo h($code) ?>">
                  <span class="custom-select__icon">
                    <img src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#flag-' . h($code); ?>" alt="<?php echo h($code) ?>">
                  </span>
            </li>
          <?php endif;?>
        <?php endforeach; ?>
      </ul>
    </form>
  </div>

</header>

<main class="inner-page">
  <section class="authorization">
    <div class="container">
      <div class="authorization__content">
          <div class="authorization__forms-wrapper">
            <?php echo $content; ?>
          </div>
      </div>
    </div>
  </section>
</main>
