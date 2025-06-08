<script src="<?php echo HOST;?>libs/ckeditor/ckeditor.js"></script>

<div class="admin-page__content-form">

  <div hidden class="notifications">
    <div class="notifications__title"></div>
  </div>

  <form 
    id="form-edit-product" 
    method="POST" 
    class="admin-form" 
    enctype="multipart/form-data">

    <div class="admin-form__row">
      <div class="admin-form__column">
        <div class="admin-form__field">
          <label class="admin-form__label" for="title">Название товара</label>
          <input id="title" name="title" class="admin-form__input input" type="text"
                  value="<?php echo h($product['title']);?>"
                  placeholder="Введите название" required/>
        </div>

        <div class="admin-form__field">
          <label class="admin-form__label" for="price">Цена</label>
          <input id="price" name="price" class="admin-form__input input" type="text"
                  value="<?php echo h($product['price']);?>"
                  placeholder="Введите цену в &euro;" required
          />
        </div>

        <div class="admin-form__field">
          <label class="admin-form__label" for="article">Артикул</label>
          <input id="article" name="article" class="admin-form__input input" type="text"
                  value="<?php echo isset($product['article']) ? h($product['article']) : '';?>"
                  placeholder="Введите артикул" 
          />
        </div>

        <div class="admin-form__field">
          <label class="admin-form__label" for="url">Ссылка</label>
          <input id="url" name="url" class="admin-form__input input" type="text"
                  value="<?php echo isset($product['url']) ? h($product['url']) : '';?>"
                  placeholder="Введите ссылку на vinted.fr" 
                  required
          />
                    
        </div>

        <div class="admin-form__field">
          <label class="admin-form__label" for="mainCat">Категория</label>
          <div class="admin-form__row">
            <select class="select" name="mainCat" id="mainCat" data-selected="<?php echo h($selectedMaiCat);?>"></select>
      
            <a 
              class="button button--s button--primary" 
              href="<?php echo HOST . 'category-new';?>">
                Новая категория
            </a>
          </div>
        </div>

        <div class="admin-form__field">
          <label class="admin-form__label" for="subCat">Подкатегория</label>
          <div class="admin-form__row">
            <select class="select" name="subCat" id="subCat" data-selected="<?php echo h($selectedSubCat);?>"></select>
    
            <a 
              class="button button--s button--primary" 
              href="<?php echo HOST . 'category-new';?>">
                Новая категория
            </a>
          </div>
        </div>

        <div class="admin-form__field">
          <label class="admin-form__label" for="brands">Выберите бренд</label>
          <div class="admin-form__row">
            <select class="select" name="brand" id="brands">
              <?php foreach ($brands as $brand) : ?>
                <option <?php echo $product['brand'] === $brand['id']  ? 'selected' : '';?> value="<?php echo h($brand['id']);?>">
                  <?php echo h($brand['title']);?>
                </option>
              <?php endforeach; ?>
            </select>
    
            <a 
              class="button button--s button--primary" 
              href="<?php echo HOST . 'brand-new';?>">
                Новый бренд
            </a>
          </div>
        </div>

        <div class="admin-form__field">
          <label class="admin-form__label" for="editor">Описание товара</label>
          <textarea class="admin-form__textarea" placeholder="Введите описание товара" name="content" rows="5" cols="1" id="editor">
              <?php echo h($product['content']) ;?>
          </textarea>
        </div>
      </div>

      <div class="admin-form__column admin-form__column--imgs">
        <div class="admin-form__field">
       
            <label class="admin-form__label" for="file">Фотографии товара</label>
            <div class="block-upload" data-preview="block">
              <div class="block-upload__description">
                <p class="block-upload__title">
                  Изображение jpg или png, рекомендуемая ширина 945px и больше, высота от 400px и более. Вес до 2Мб.
                </p>
              </div>

              <div class="block-upload__button ">
                  <span class="block-upload__input-fake">Выбрать изображения</span>
                  <input id="file" name="cover[]" class="block-upload__input-real" type="file" multiple data-preview="input">
              </div>

              <!-- PREVIEW IMG -->
              <div class="block-upload__preview active" data-preview="container" data-dragg-and-drop="">
                <?php foreach ($productImages as $image) : ?>
                  <div class="admin-form__img-wrapper" data-preview="image-wrapper" data-url="blob:https://vvintage/2932f5ed-3290-49ba-bfcd-09f199a163cd" draggable="true">
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

    <div class="admin-form__button-wrapper admin-form__button-row">
      <?php if (isset($_POST['submit'])) : ?>
        <a class="button button--m button--outline" href="<?php echo HOST . 'admin/shop';?>" title="Вернуться к списку товаров">К списку товаров</a>
      <?php else : ?>
        <a class="button button--m button--outline" href="<?php echo HOST . 'admin/shop';?>" title="Отмена">Отмена</a>
      <?php endif; ?>
      <button class="button button--m button--primary" type="submit" name="submit" value="submit">Сохранить</button>
    </div>
  </form>
</div>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    if(typeof CKEDITOR !== 'undefined') {
      CKEDITOR.replace('editor', {
        filebrowserUploadMethod: 'form',
        filebrowserUploadUrl: '<?php echo HOST;?>libs/ck-upload/upload.php'
      });
    }
   
  }); 
</script>