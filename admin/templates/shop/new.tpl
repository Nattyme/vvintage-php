<script src="<?php echo HOST;?>libs/ckeditor/ckeditor.js"></script>

<section class="shop">
  <div class="shop__container">

    <?php /* include ROOT . "admin/templates/components/errors.tpl"; */ ?>
    <?php /* include ROOT . "admin/templates/components/success.tpl"; */ ?>

    <div hidden class="notifications mb-20">
      <div class="notifications__title"></div>
    </div>

    <form id="form-add-product" method="POST" class="shop-form-new" data-url = "<?php echo HOST;?>admin/form-add" enctype="multipart/form-data">
      <div class="form__row">
        <div class="form__column">
          <fieldset class="form__field">
            <label class="form__item">
              <span class="form__text">Введите название товара</span>
              <input name="title" class="form__input" type="text"
                     value="<?php echo isset($_POST['title']) ? $_POST['title'] : ''; ?>"
                     placeholder="Название товара" />
            </label>
          </fieldset>

          <fieldset class="form__field">
            <label class="form__item">
              <span class="form__text">Цена</span>
              <input name="price" class="form__input" type="text"
                     value="<?php echo isset($_POST['price']) ? $_POST['price'] : ''; ?>"
                     placeholder="Введите стоимость товара" />
            </label>
          </fieldset>

          <fieldset class="form__field form__field--input-with-button">
            <label class="form__item">
              <span class="form__text">Выберите категорию</span>
              <select class="form__select" name="cat">
                <?php foreach ($cats as $cat) : ?>
                  <option value="<?php echo $cat['id']; ?>"><?php echo $cat['title']; ?></option>
                <?php endforeach; ?>
              </select>
            </label>
            <div class="form__item">
              <a 
                class="button button-outline button-outline--small" 
                href="<?php echo HOST;?>category-new?shop">
                  Новая категория
              </a>
            </div>
          </fieldset>

          <fieldset class="form__field form__field--input-with-button">
            <label class="form__item">
              <span class="form__text">Выберите бренд</span>
              <select class="form__select" name="brand">
                <?php foreach ($brands as $brand) : ?>
                  <option value="<?php echo $brand['id']; ?>"><?php echo $brand['title']; ?></option>
                <?php endforeach; ?>
              </select>
            </label>
            <div class="form__item">
              <a 
                class="button button-outline button-outline--small" 
                href="<?php echo HOST;?>brand-new">
                  Новый бренд
              </a>
            </div>
          </fieldset>

          <fieldset class="form__field">
            <label class="form__item">
              <span class="form__text">Описание товара</span>
            </label>
            <!-- <textarea class="form__textarea" placeholder="Введите описание товара" name="desc" rows="5" cols="1" id="editor"><?php echo isset($_POST['content']) ? $_POST['content'] : 'Описание товара'; ?></textarea> -->
            <textarea class="form__textarea" placeholder="Введите описание товара" name="content" rows="5" cols="1" id="editor">Описание</textarea>
          </fieldset>
        </div>

        <div class="form__column form__column--imgs">
          <fieldset class="form__field">
            <label class="form__item">
              <span class="form__text">Фотографии товара</span>
              <div class="block-upload" data-preview="block">
                <div class="block-upload__description">
                  <p class="block-upload__title">
                    Изображение jpg или png, рекомендуемая ширина 945px и больше, высота от 400px и более. Вес до 2Мб.
                  </p>
                </div>

                <div class="block-upload__button ">
                  <label>
                    <span class="block-upload__input-fake">Выбрать изображения</span>
                    <input name="cover[]" class="block-upload__input-real" type="file" multiple data-preview="input">
                  </label>
                </div>

                <div class="block-upload__preview" data-preview="container" data-dragg-and-drop></div>
              </div>
            </label>
          </fieldset>
        </div>
      </div>

      <div class="form__button-wrapper form__button-row">
        <button class="form__button button-solid" type="submit" name="submit" value="submit">Опубликовать</button>
        <a class="button button-outline button-outline--admin" href="<?php echo HOST;?>shop">Отмена</a>
      </div>
    </form>
  </div>
</section>

<script>
  CKEDITOR.replace('editor', {
    filebrowserUploadMethod: 'form',
    filebrowserUploadUrl: '<?php echo HOST;?>libs/ck-upload/upload.php'
  });
</script>
