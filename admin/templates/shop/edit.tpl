<script src="<?php echo HOST;?>libs/ckeditor/ckeditor.js"></script>

<div class="admin-page__content-form">
  <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
  <?php include ROOT . "admin/templates/components/success.tpl"; ?>

  <form class="admin-form" 
        method="POST" 
        action="<?php echo HOST;?>admin/shop-edit?id=<?php echo $product['id']; ?>" enctype="multipart/form-data">

    <div class="admin-form__item">
      <h2 class="heading">Редактировать товар</h2>
    </div>
    <div class="admin-form__item">
      <label class="input__label">
        Название товара 
        <input name="title" 
               class="input input--width-label" 
               type="text" 
               value="<?php echo $product['title']; ?>"
        />
      </label>
    </div>
    <div class="admin-form__item">
      <label class="select-label">
        Выберите марку товара
        <select class="select" name="brand">
          <?php foreach ($brands as $brand) : ?>
            <option 
              <?php echo $product['brand'] === $brand['id']  ? 'selected' : '';?>
              value="<?php echo $brand['id'];?>"><?php echo $brand['title'];?>
            </option>
          <?php endforeach; ?>
        </select>
      </label>
    </div>
    <div class="admin-form__item">
      <label class="input__label">
        Цена товара 
        <input name="price" 
               class="input input--width-label" 
               type="text" 
               value="<?php echo $product['price']; ?>"
        />
      </label>
    </div>
    <div class="admin-form__item">
      <label class="select-label">Выберите категорию 
        <select class="select" name="cat">
          <?php foreach ($cats as $cat) : ?>
            <option 
              <?php echo $product['cat'] == $cat['id'] ? 'selected' : '';?> 
              value=<?php echo $cat['id'];?>><?php echo $cat['title'];?>
            </option>
          <?php endforeach; ?>
        </select>
      </label>
    </div>
    <div class="admin-form__item">
      <label class="textarea__label mb-15" name="editor">
        Описание товара 
      </label>
      <textarea name="content" class="textarea textarea--width-label" id="editor">
        <?php echo $product['content'] ;?>
      </textarea>
    </div>
    <div class="admin-form__item">
      <div class="block-upload">
        <div class="block-upload__description">
          <div class="block-upload__title">Фотография товара:</div>
          <p>Изображение jpg или png, рекомендуемая ширина 945px и больше, высота от 400px и более. Вес до 2Мб.</p>
          <div class="block-upload__file-wrapper">
            <input name="cover" class="file-button" type="file">
          </div>
        </div>
        <?php if (!empty($product->cover)) : ?>
          <div class="block-upload__img">
            <img src="<?php echo HOST . 'usercontent/products/' . $product['coverSmall'];?>" alt="Загрузка картинки" />
          </div>
          <label class="checkbox__item mt-15">
            <input class="checkbox__btn" type="checkbox" name="delete-cover">
            <span class="checkbox__label">Удалить обложку</span>
          </label>
        <?php endif; ?>
      </div>
    </div>

    <div class="admin-form__item buttons">
      <button name="submit" value="submit" class="primary-button" type="submit">Сохранить изменения</button>
      <?php if (isset($_POST['submit'])) : ?>
        <a class="secondary-button" href="<?php echo HOST;?>admin/shop" title="Вернуться к списку товаров">К списку товаров</a>
      <?php else : ?>
        <a class="secondary-button" href="<?php echo HOST;?>admin/shop" title="Отмена">Отмена</a>
      <?php endif; ?>
    </div>
  </form>
</div>

<script>
  CKEDITOR.replace('editor', {
    filebrowserUploadMethod: 'form',
    filebrowserUploadUrl: '<?php echo HOST;?>libs/ck-upload/upload.php'
  });
</script>
