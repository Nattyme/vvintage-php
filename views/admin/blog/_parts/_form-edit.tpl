<form 
  class="admin-form" 
  method="POST" 
  action="<?php echo HOST . 'admin/post-edit?id=' . h($post->id); ?>" 
>
  <div class="admin-form__row">
    <div class="admin-form__column">
      
      <input type="hidden" name="_method" value="PUT">
    
      <div class="admin-form__field">
        <label class="admin-form__label" for="title">Дата последнего обновления</label>
  
        <input  id="title" name="title" class="admin-form__input input" type="text"
                value="<?php echo h($post->edit_time);?>"
                placeholder="Введите название статьи" disabled
        />
      </div>

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
              <?php $firstKey = array_key_first($languages); ?>
              <?php foreach ($languages as $code => $value ) : ?>
                <div class="tab__block  <?php echo $code === $firstKey ? 'active' : ''; ?>" data-control="tab-block">
                  <?php include ROOT . "views/admin/shop/translations/_fields.tpl";?>
                </div>
              <?php endforeach;?>
            </div>
          </div>
          <!--// Блоки с контентом -->
        </div>
      </div>


      <div class="admin-form__field">
        <label class="admin-form__label" for="title">Название для страницы статьи (латиницей: chasy-chanel)</label>
        <input id="slug" name="slug" class="admin-form__input input" type="text"
                value="<?php echo isset($_POST['slug']) ? h($_POST['slug']) : h($post->slug); ?>"
                placeholder="Введите название старницы" required/>
      </div>



    </div>
    <div class="admin-form__column admin-form__column--imgs">
      <input type="hidden" name="existing_images[]" value="<?php echo h($post->cover_small); ?>">
      <div class="admin-form__field">
      
          <label class="admin-form__label" for="file">Фотографии товара</label>
          <div class="block-upload" data-preview="block" data-dragg-and-drop>
            <div class="block-upload__description">
              <p class="block-upload__title">
                Изображение jpg или png, рекомендуемая ширина 945px и больше, высота от 400px и более. Вес до 2Мб.
              </p>
            </div>

            <!-- PREVIEW IMG -->
            <div class="block-upload__preview" data-preview="container" data-dragg-preview>

                <div 
                    class="block-upload__img-wrapper" 
                    data-preview="image-wrapper" 
                    draggable="true" 
                    data-url="<?php echo HOST . 'usercontent/blog/' . $post->cover_small;?>"
                >
                  <img 
                    src="<?php echo HOST . 'usercontent/blog/' . $post->cover_small;?>" 
                    loading="lazy"      
                  >

      
                  <button type="button" class="button button--close button--close-with-bg cross-wrapper" data-preview="btn-close">
                      <span class="leftright"></span><span class="rightleft"> </span>
                  </button>
               
                </div>
             
            </div>
            <div class="block-upload__dropzone" data-dragg-dropzone>
              <p>Перетащите файлы сюда</p>
              или нажмите на кнопку 
              <div class="block-upload__button admin-form__block-upload__button">
                <!-- Кастомная кнопка -->
                <button type="button" class="btn-add-photo" id="btn-add-photo">
                  <svg class="icon icon--add_photo">
                    <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#add_photo';?>"></use>
                  </svg>
                </button>
                <input id="file" name="cover[]" class="block-upload__input-real" type="file" multiple data-preview="input" hidden>
              </div>
            </div>
            <!-- // PREVIEW IMG -->
          </div>
        </label>
      </div>
    </div>
  </div>

    <!-- CSRF-токен -->
  <input type="hidden" name="csrf" value="<?php echo h(csrf_token()) ;?>">

  <div class="admin-form__button-wrapper admin-form__button-row">
    <?php if (isset($_POST['submit'])) : ?>
      <a class="button button--m button--outline" href="<?php echo HOST . 'admin/shop';?>" title="Вернуться к списку товаров">К списку товаров</a>
    <?php else : ?>
      <a class="button button--m button--outline" href="<?php echo HOST . 'admin/shop';?>" title="Отмена">Отмена</a>
    <?php endif; ?>
    <button class="button button--m button--primary" type="submit" name="submit" value="submit">Сохранить</button>
  </div>
</form>
