<script src="<?php echo HOST;?>libs/ckeditor/ckeditor.js"></script>

<section class="shop">
  <div class="shop__container">
  
  <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
  <?php include ROOT . "admin/templates/components/success.tpl"; ?>

  <form method="POST" class="shop-form-new"  action="<?php echo HOST;?>admin/shop-new" enctype="multipart/form-data" enctype="multipart/form-data">
    <div class="form__row">
      <div class="form__column">
        <fieldset class="form__field">
          <label class="form__item">
            <span class="form__text">Введите название товара</span>
            <input name="title" class="form__input" type="text"
               value="<?php echo isset($_POST['title']) ? $_POST['title'] : ''; ?>"
               placeholder="Название товара"
            />
          </label>
        </fieldset>

        <fieldset class="form__field">
          <label class="form__item">
            <span class="form__text">Цена</span>
            <input name="price" class="form__input" type="text"
                  value="<?php echo isset($_POST['price']) ? $_POST['price'] : ''; ?>"
                  placeholder="Введите стоимость товара"
            />
          </label>
        </fieldset>

        <fieldset class="form__field form__field--input-with-button">
          <label class="form__item">
            <span class="form__text">Выберите категорию </span>
            <select class="form__select" name="cat">
              <?php foreach ($cats as $cat) : ?>
              <option value="<?php echo $cat['id'];?>"><?php echo $cat['title'];?></option>
              <?php endforeach; ?>
            </select>
          </label>
          <div class="form__item">
            <a class="button-outline button-outline--admin" href="<?php HOST;?>category-new?shop">Создать новую категорию</a>
          </div>
        </fieldset>
        <fieldset class="form__field form__field--inputs-wrapper">
          <label class="form__item">
            <span class="form__text">Выберите бренд</span>
            <select class="form__select" name="brand">
              <?php foreach ($brands as $brand) : ?>
                <option value="<?php echo $brand['id'];?>"><?php echo $brand['title'];?></option>
              <?php endforeach; ?>
            </select>
          </label>
          <div class="form__item d-flex justify-content-between mb-20">
            <a class="button-outline button-outline--admin" href="<?php HOST;?>brand-new">Создать новый бренд</a>
          </div>
        </fieldset>

        
        <fieldset class="form__field">
          <label class="form__item" name="editor">
            <span class="form__text">Описание товара</span>
          </label>
          <textarea class="form__textarea" placeholder="Введите описание товара" name="desc" rows="5" cols="1" name="content" id="editor">
            <?php echo isset($_POST['content']) ? $_POST['content'] : 'Описание товара'; ?>"
          </textarea>
        </fieldset>

      </div>

      <div class="form__column form__column--imgs">
        <fieldset class="form__field" data-preview="block">
          <label class="form__item">
            <span class="form__text">Фотографии товара</span>
        
            <div class="block-upload">
                <div class="block-upload__description">
                  <p class="block-upload__title">Изображение jpg или png, рекомендуемая ширина 945px и больше, высота от 400px и более. Вес до 2Мб.</p>
                </div>
              
                <div class="block-upload__button">
                  <label>
                    <span class="file-input-fake">Выбрать изображения</span>
                    <input name="cover[]" class="file-input-real" data-preview="input" type="file" multiple>
                  </label>
                </div>
            </div>
          </label>
          <div class="block-upload__file-wrapper sortable-preview" data-preview="container"></div>
            <!-- <div class="form__img-wrapper">
              <button type="button" class="button-close">
                <svg class="icon icon--close">
                  <use href="./../../../img/svgsprite/sprite.symbol.svg#close"></use>
                </svg>
              </button>
            
              <img src="'static/img/arrival/chanel_gold_ring_with_precious_stones_solitaire_2.jpeg';?>" alt="">
       
         -->
          </div>
        </fieldset>
       

      </div>
    </div>


    <div class="form__button-wrapper">
      <button class="form__button button-solid" type="submit" name="submit" value="submit">Опубликовать</button>
      <a class="button-outline button-outline--admin" href="<?php echo HOST;?>shop">Отмена</a>
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
