<script src="<?php echo HOST;?>libs/ckeditor/ckeditor.js"></script>

<section class="shop">
  <div class="shop__container">

    <div hidden class="notifications">
      <div class="notifications__title"></div>
    </div>

    <form 
      id="form-edit-product" 
      method="POST" 
      class="shop-form-new" 
      enctype="multipart/form-data">

      <div class="form__row">
        <div class="form__column">


          <div class="form__field">
            <label class="form__item">
              <span class="form__text">Название товара</span>
              <input name="title" class="form__input input" type="text"
                     value="<?php echo h($product['title']);?>"
                     placeholder="Введите название" required/>
            </label>
          </div>

          <div class="form__field">
            <label class="form__item">
              <span class="form__text">Цена</span>
              <input name="price" class="form__input input" type="text"
                     value="<?php echo h($product['price']);?>"
                     placeholder="Введите цену в &euro;" required/>
            </label>
          </div>

          <div class="form__field">
            <label class="form__item">
              <span class="form__text">Артикул</span>
              <input name="article" class="form__input input" type="text"
                     value="<?php echo isset($product['article']) ? h($product['article']) : '';?>"
                     placeholder="Введите артикул" />
            </label>
          </div>

          <div class="form__field">
            <label class="form__item">
              <span class="form__text">Ссылка</span>
              <input name="url" class="form__input input" type="text"
                     value="<?php echo isset($product['url']) ? h($product['url']) : '';?>"
                     placeholder="Введите ссылку на vinted.fr" 
                     required
                    />
                     
            </label>
          </div>

          <div class="form__field form__field--input-with-button">
            <label class="form__item">
              <span class="form__text">Категория</span>
              <select class="select" name="mainCat" id="mainCat" data-selected="<?php echo h($selectedMaiCat);?>"></select>
            </label>
            <div class="form__item">
              <a 
                class="button button-outline button-outline--small" 
                href="<?php echo HOST;?>category-new?shop">
                  Новая категория
              </a>
            </div>
          </div>
          <div class="form__field form__field--input-with-button">
            <label class="form__item">
              <span class="form__text">Подкатегория</span>
              <select class="select" name="subCat" id="subCat" data-selected="<?php echo h($selectedSubCat);?>"></select>
            </label>
            <div class="form__item">
              <a 
                class="button button-outline button-outline--small" 
                href="<?php echo HOST;?>category-new?shop">
                  Новая категория
              </a>
            </div>
          </div>

          <div class="form__field form__field--input-with-button">
            <label class="form__item">
              <span class="form__text">Выберите бренд</span>
              <select class="select" name="brand" id="brands">
                <?php foreach ($brands as $brand) : ?>
                  <option <?php echo $product['brand'] === $brand['id']  ? 'selected' : '';?> value="<?php echo h($brand['id']);?>">
                    <?php echo h($brand['title']);?>
                  </option>
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
          </div>

          <div class="form__field">
            <label class="form__item">
              <span class="form__text">Описание товара</span>
            </label>
            <textarea class="form__textarea" placeholder="Введите описание товара" name="content" rows="5" cols="1" id="editor">
               <?php echo h($product['content']) ;?>
            </textarea>
          </div>
        </div>

        <div class="form__column form__column--imgs">
          <div class="form__field">
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

                <!-- PREVIEW IMG -->
                <div class="block-upload__preview active" data-preview="container" data-dragg-and-drop="">
                  <?php foreach ($productImages as $image) : ?>
                    <div class="form__img-wrapper" data-preview="image-wrapper" data-url="blob:https://vvintage/2932f5ed-3290-49ba-bfcd-09f199a163cd" draggable="true">
                      <img src="<?php echo HOST . 'usercontent/products/' . $image['filename_small'];?>" draggable="true" loading="lazy">
                      <button type="button" class="button button-close button-close--with-bg cross-wrapper" data-preview="btn-close">
                          <span class="leftright"></span><span class="rightleft"> </span>
                      </button>
                    </div>
                  <?php endforeach;?>
                </div>
                <!-- // PREVIEW IMG -->
              </div>
            </label>
          </div>
        </div>
      </div>

      <!-- CSRF-токен -->
      <input type="hidden" name="csrf" value="<?php echo h(csrf_token()) ;?>">

      <div class="form__button-wrapper form__button-row">
        <?php if (isset($_POST['submit'])) : ?>
          <a class="form__button button-solid" href="<?php echo HOST;?>admin/shop" title="Вернуться к списку товаров">К списку товаров</a>
        <?php else : ?>
          <a class="button button-outline button-outline--admin" href="<?php echo HOST;?>shop" title="Отмена">Отмена</a>
        <?php endif; ?>
        <button class="form__button button-solid" type="submit" name="submit" value="submit">Сохранить</button>
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
