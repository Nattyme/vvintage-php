<div class="custom-select <?php echo isset($pageClass) && $pageClass === 'authorization-page' ? 'custom-select--min' : '';?>" custom-select>
  <form id="language-selector" method="GET" custom-select-form>
    @csrf
    
    <input type="hidden" name="lang" id="selected-language" value="<?php echo h($this->currentLang ?? '') ?>" custom-select-input>
    
    <div class="select-trigger" tabindex="0" aria-haspopup="listbox" aria-expanded="false" custom-select-trigger>
          <?php 
            if (isset($currentLang) && isset($languages[$currentLang])) {
              $code = h($currentLang);
              $label = h($languages[$currentLang]);
              echo "<span class='select-icon'><img src='" . HOST . "static/img/svgsprite/stack/svg/sprite.stack.svg#flag-$code' alt='$code'></span>";

              if (!isset($pageClass) || $pageClass !== 'authorization-page') {
                echo "<div class='custom-select__text'>$label</div>";
              }
            } else {
              if (!isset($pageClass) || $pageClass !== 'authorization-page') {
                echo "<div class='custom-select__text'>Выберите язык</div>";
              }
             
            }
          ?>
    </div>
        
    <ul class="select-options" role="listbox" tabindex="-1" custom-select-options>
      <?php foreach ($languages as $code => $label) : 
        $isActive = ($code === $currentLang) ? 'custom-select__item--active' : '';
      ?>

        <?php if (! $isActive ) : ?>
          <li 
            role="option" 
            aria-selected="<?= $code === $currentLang ? 'true' : 'false' ?>"
            data-value="<?php echo h($code) ?>">
                <span class="select-icon">
                  <img src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#flag-' . h($code); ?>" alt="<?php echo h($code) ?>">
                </span>

                <?php if (!isset($pageClass) || $pageClass !== 'authorization-page') : ?>
                  <span>
                    <?php echo h($label) ?>
                  </span>
                <?php endif;?>
          </li>
        <?php endif;?>
      <?php endforeach; ?>
    </ul>
  </form>
</div>