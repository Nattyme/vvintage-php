<script src="<?php echo HOST;?>libs/ckeditor/ckeditor.js"></script>

    <?php include ROOT . 'admin/templates/components/errors.tpl'; ?>
    <?php include ROOT . 'admin/templates/components/success.tpl'; ?>

    <div class="admin-page__content-form">
        <form 
          id="form-edit-main" 
          method="POST" 
          class="admin-form" 
          enctype="multipart/form-data">

          <div class="admin-form__row">
            <div class="admin-form__column">


              <div class="admin-form__field">
                <label class="admin-form__item">
                  <span class="admin-form__text">Заголовок главной секции</span>
                  <input name="hero_title" class="admin-form__input input" type="text"
                        value=""
                        placeholder="Введите заголовок главной секции" required/>
                </label>
              </div>

              <div class="admin-form__field">
                <label class="admin-form__item">
                  <span class="admin-form__text">Текст главной секции</span>
                  <input name="hero_text" class="admin-form__input input" type="text"
                        value=""
                        placeholder="Введите текст главной секции" required/>
                </label>
              </div>

              <div class="admin-form__field">
                <label class="admin-form__item">
                  <span class="admin-form__text">Заголовок секции услуг</span>
                  <input name="services_title" class="admin-form__input input" type="text"
                        value="<?php echo isset($product['article']) ? h($product['article']) : '';?>"
                        placeholder="Введите заголовок секции услуг" />
                </label>
              </div>


              <div class="admin-form__field">
                <label class="admin-form__item">
                  <span class="admin-form__text">Описание товара</span>
                </label>
                <textarea class="admin-form__textarea" placeholder="Введите описание товара" name="content" rows="5" cols="1" id="editor">
                  <?php echo h($product['content']) ;?>
                </textarea>
              </div>
            </div>

          </div>

          <!-- CSRF-токен -->
          <input type="hidden" name="csrf" value="<?php echo h(csrf_token()) ;?>">

          <div class="admin-form__button-wrapper admin-form__button-row">
            <?php if (isset($_POST['submit'])) : ?>
              <a class="button button--m button--outline" href="<?php echo HOST;?>admin/shop" title="Вернуться к списку товаров">К списку товаров</a>
            <?php else : ?>
              <a class="button button--m button--outline" href="<?php echo HOST;?>shop" title="Отмена">Отмена</a>
            <?php endif; ?>
            <button class="button button--m button--primary" type="submit" name="submit" value="submit">Сохранить</button>
          </div>
        </form>
    </div>

   
  </div>

<script>
  CKEDITOR.replace('editor', {
    filebrowserUploadMethod: 'form',
    filebrowserUploadUrl: '<?php echo HOST;?>libs/ck-upload/upload.php'
  });
</script>
