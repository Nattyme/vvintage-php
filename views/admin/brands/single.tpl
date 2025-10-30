<div class="admin-page__content-form">

  <form 
    class="admin-form" 
    method="POST" 
    <?php if ($brand && $brand->id) : ?>
      action="<?php echo HOST;?>admin/brand-edit/<?php echo u($brand->id); ?>"
    <?php endif;?>
  >

  <?php include ROOT . "views/components/errors.tpl"; ?>
  <?php include ROOT . "views/components/success.tpl"; ?>

    <!-- CSRF-токен -->
    <input type="hidden" name="csrf" value="<?php echo h(csrf_token()); ?>">

    <div class="admin-form__field">
      <div class="admin-form__item" data-control="tab">
        <!-- Навигация -->
        <div class="tab__nav" data-control="tab-nav">
          <?php $firstKey = array_key_first($languages); ?>
          <?php foreach ($languages as $code => $value ) : ?>
            <button type="button" class="tab__nav-button tab__nav-button--flags <?php echo $code === $firstKey ? 'active' : ''; ?>" data-control="tab-button" 
                    title="Перейти в редактирование текст на кнопке статуса">
              <img src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#flag-' . $code;?>">
            </button>
          <?php endforeach;?>
        </div>
        <!-- Навигация -->

        <!-- Блоки с контентом -->
        <div class="admin-form__item">
          <div class="tab__content" data-control="tab-content">
            <?php $translations = isset($brand) ? $brand->translations : null; ?>
            <?php foreach ($languages as $code => $value ) : ?>
                <div class="tab__block <?php echo $code === $firstKey ? 'active' : ''; ?>" data-control="tab-block">
                  <?php include ROOT . "views/admin/brands/translations/_fields.tpl";?>
                </div>
            <?php endforeach;?>
          </div>
        </div>
        <!--// Блоки с контентом -->
      </div>

    </div>

    
    <!-- Логотип бренда -->
    <div class="admin-form__field">
      <label class="admin-form__label" for="image">Логотип бренда</label>
      <?php if (isset($brand) && $brand->image): ?>
        <div class="admin-form__image-preview">
          <img 
            src="<?php echo HOST . 'uploads/brands/' . h($brand->image); ?>" 
            alt="Логотип <?php echo h($brand->title); ?>" width="100"
          >
        </div>
      <?php endif; ?>
      <input 
        id="image" 
        name="image" 
        class="admin-form__input" 
        type="file" 
        accept="image/*"
      />
      <small>Оставьте пустым, если не хотите менять текущий логотип</small>
    </div>


    <div class="admin-form__buttons buttons">
      <button name="submit" value="submit" class="button button--m button--primary" type="submit">Сохранить</button>
      <a class="button button--m button--outline" href="<?php echo HOST . 'admin/brand'; ?>">Отмена</a>
    </div>
  </form>
</div>
