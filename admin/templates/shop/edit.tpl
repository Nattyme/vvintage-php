<script src="<?php echo HOST;?>libs/ckeditor/ckeditor.js"></script>

<section class="shop">
  <div class="shop__container">

    <div hidden class="notifications">
      <div class="notifications__title"></div>
    </div>

    <form 
      id="form-edit-product" 
      method="POST" 
      action="<?php echo HOST;?>admin/shop-edit?id=<?php echo $product['id']; ?>"
      class="shop-form-new" 
      enctype="multipart/form-data"
    >

      <div class="form__row">
        <div class="form__column">


          <fieldset class="form__field">
            <label class="form__item">
              <span class="form__text">Название</span>
              <input name="title" class="form__input input" type="text"
                     value="<?php echo $product['title']?>"
                     placeholder="Введите название" required
              />
            </label>
          </fieldset>

          <fieldset class="form__field">
            <label class="form__item">
              <span class="form__text">Цена</span>
              <input name="price" class="form__input input" type="text"
                     value="<?php echo $product['price']?>"
                     placeholder="Введите цену в &euro;" required/>
            </label>
          </fieldset>

          <fieldset class="form__field">
            <label class="form__item">
              <span class="form__text">Артикул</span>
              <input name="article" class="form__input input" type="text"
                     value="<?php echo isset($product['article']) ? $product['article'] : '';?>"
                     placeholder="Введите артикул" />
            </label>
          </fieldset>
          <fieldset class="form__field">
            <label class="form__item">
              <span class="form__text">Ссылка</span>
              <input name="url" class="form__input input" type="text"
                     value="<?php echo isset($_POST['url']) ? $_POST['url'] : '';?>"
                     placeholder="Введите ссылку на vinted.fr" />
            </label>
          </fieldset>

          <fieldset class="form__field form__field--input-with-button">
            <label class="form__item">
              <span class="form__text">Категория</span>
              <select class="select" name="mainCat" id="mainCat">
                <?php if (isset($_POST['mainCat']) ) : ?>
                  <option value="<?php echo $_POST['mainCat'];?>"><?php echo $_POST['mainCat'];?></option>
                <?php else : ?>
                  <option value="">Выберите категорию</option>
                <?php endif;?>
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
              <span class="form__text">Подкатегория</span>
              <select class="select" name="subCat" id="subCat">
                <?php foreach ($cats as $cat) : ?>
                  <option 
                    <?php echo $product['cat'] == $cat['id'] ? 'selected' : '';?> 
                    value=<?php echo $cat['id'];?>><?php echo $cat['title'];?>
                  </option>
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
              <select class="select" name="brand" id="brands">
                <?php foreach ($brands as $brand) : ?>
                  <option 
                    <?php echo $product['brand'] === $brand['id']  ? 'selected' : '';?>
                    value="<?php echo $brand['id'];?>"><?php echo $brand['title'];?>
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
          </fieldset>

          <fieldset class="form__field">
            <label class="form__item">
              <span class="form__text">Описание товара</span>
            </label>
            <textarea class="form__textarea" placeholder="Введите описание товара" name="content" rows="5" cols="1" id="editor">
               <?php echo $product['content'] ;?>
            </textarea>
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

                <div class="block-upload__preview" data-preview="container" data-dragg-and-drop>
                    <?php if (!empty($product->cover)) : ?>
                      <img src="<?php echo HOST . 'usercontent/products/' . $product['coverSmall'];?>" alt="Загрузка картинки" />
                    <?php endif; ?>
                </div>
              </div>
            </label>
          </fieldset>
        </div>
      </div>

      <div class="form__button-wrapper form__button-row">
        <!-- <a class="button button-outline button-outline--admin" href="<?php echo HOST;?>shop">Отмена</a> -->
        <?php if (isset($_POST['submit'])) : ?>
          <a class="form__button button-solid" href="<?php echo HOST;?>admin/shop" title="Вернуться к списку товаров">К списку товаров</a>
        <?php else : ?>
          <a class="button button-outline button-outline--admin" href="<?php echo HOST;?>shop" title="Отмена">Отмена</a>
        <?php endif; ?>
        <button class="form__button button-solid" type="submit" name="submit" value="submit">Сохранить изменения</button>
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
