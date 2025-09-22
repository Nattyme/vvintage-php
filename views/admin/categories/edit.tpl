<div class="admin-page__content-form">
  
  <?php include (ROOT . "views/components/errors.tpl"); ?>
  <?php include (ROOT . "views/components/success.tpl"); ?>

  <form 
      id="form-edit-category" 
      method="POST" 
      action="<?php echo HOST;?>admin/category-edit/<?php echo u($category->getId());?>"
      class="admin-form"
  >

  <?php if ($parentCategory) : ?> 
    <div class="admin-form__field">
      <label class="admin-form__label" for="title">
        <?php echo 'Обвновление в разделе: ' . h($parentCategory->getTitle());?>
      </label>
      <input 
        id="parent" 
        name="parent_id" 
        class="admin-form__input admin-form__input--width-label" 
        type="text" 
        value="<?php echo h($parentCategory->getId());?>"
        hidden
      />
      

    </div>
  <?php endif; ?> 

      <div class="admin-form__field">
        <label class="admin-form__label" for="title">Название категории</label>
        <input 
          id="title"
          name="title" 
          class="admin-form__input admin-form__input--width-label" 
          type="text" 
          placeholder="Введите заголовок категории" 
          value="<?php echo h(trim($category->getTitle()));?>"
          required
        />
      </div>

      <div class="admin-form__field">
        <div class="admin-form__item" data-control="tab">
          <!-- Навигация -->
          <div class="tab__nav" data-control="tab-nav">
            <?php $firstKey = array_key_first($languages); ?>
            <?php foreach ($languages as $code => $value ) : ?>
              <button type="button" class="tab__nav-button tab__nav-button--flags <?php echo $code === $firstKey ? 'active' : ''; ?>" data-control="tab-button" 
                      title="Перейти в редактирование языка <?php echo $code; ?>">
                <img src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#flag-' . $code;?>">
              </button>
            <?php endforeach;?>
          </div>
          <!-- Навигация -->

          <!-- Блоки с контентом -->
          <div class="admin-form__item">
            <div class="tab__content" data-control="tab-content">
              <?php foreach ($languages as $code => $value ) : ?>
                <div class="tab__block <?php echo $code === $firstKey ? 'active' : ''; ?>" data-control="tab-block">
                <?php include (ROOT . "views/admin/categories/translations/_fields.tpl");?>
                </div>
              <?php endforeach;?>
            </div>
          </div>
          <!--// Блоки с контентом -->
        </div>

      </div>

      <!-- CSRF-токен -->
      <input type="hidden" name="csrf" value="<?php echo h(csrf_token()) ;?>">

      <div class="admin-form__buttons buttons">
        <a class="button button--m button--outline" href="<?php echo HOST;?>admin/category" title="Отмена">Отмена</a>
        <button class="button button--m button--primary" type="submit" name="submit" value="submit">Сохранить</button>
      </div>
  </form>

</div>

