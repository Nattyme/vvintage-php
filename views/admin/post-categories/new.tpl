<div class="admin-page__content-form">
  
  <?php include ROOT . "views/components/errors.tpl"; ?>
  <?php include ROOT . "views/components/success.tpl"; ?>

  <form class="admin-form" method="POST" action="<?php echo HOST;?>admin/category-new">
    <div class="admin-form__field">
      <label class="admin-form__label" for="title">Введите название категории</label>
      <input 
        id="title" 
        name="title" 
        class="admin-form__input admin-form__input--width-label" 
        type="text" 
        placeholder="Заголовок категории"
        required
      />
    </div>

    <div class="header__lang custom-select" data-custom-select>

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
              <svg class="icon icon--arrow-down">

              </svg>
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

    </div>


    <!-- CSRF-токен -->
    <input type="hidden" name="csrf" value="<?php echo h(csrf_token()) ;?>">

    <div class="admin-form__buttons buttons">
      <a class="button button--m button--outline" href="<?php echo HOST . 'admin/category';?>">
        Отмена
      </a>
      <button name="submit" value="submit" class="button button--m button--primary" type="submit">
        Создать
      </button>
    </div>
  </form>
</div>

