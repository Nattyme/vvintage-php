<script src="<?php echo HOST;?>libs/ckeditor/ckeditor.js"></script>

<div class="admin-page__content-form">
  <div hidden class="notifications">
    <div class="notifications__title"></div>
  </div>

  <form id="form-add-product" method="POST" class="admin-form" enctype="multipart/form-data">
    <div class="admin-form__row">
      <div class="admin-form__column">
        <div class="admin-form__field">
          <label class="admin-form__label" for="title">Название товара</label>
          <input 
            id="title"
            name="title" 
            class="admin-form__input input" 
            type="text"
            value="<?php echo isset($_POST['title']) ? h($_POST['title']) : '';?>"
            placeholder="Введите название" 
            required
          />
        </div>

        <div class="admin-form__field">
          <label class="admin-form__label" for="price">Цена</label>
          <input 
            id="price"
            name="price" 
            class="admin-form__input input" 
            type="text"
            value="<?php echo isset($_POST['price']) ? h($_POST['price']) : '';?>"
            placeholder="Введите цену в &euro;" 
            required
          />
        </div>

        <div class="admin-form__field">
          <label class="admin-form__label" for="article">Артикул</label>
          <input 
            id="article" 
            name="article" 
            class="admin-form__input input" 
            type="text"
            value="<?php echo isset($_POST['article']) ? h($_POST['article']) : '';?>"
            placeholder="Введите артикул" 
          />
        </div>

        <div class="admin-form__field">
          <label class="admin-form__label" for="url">Ссылка</label>
          <input 
            id="url"
            name="url" 
            class="admin-form__input input" 
            type="text"
            value="<?php echo isset($_POST['url']) ? u($_POST['url']) : '';?>"
            placeholder="Введите ссылку на vinted.fr" 
          />
        </div>

        <div class="admin-form__field">
            <label class="admin-form__label" for="mainCat">Категория</label>
            <div class="admin-form__row">
              <select class="select" name="mainCat" id="mainCat">
                <?php if (isset($_POST['mainCat']) ) : ?>
                  <option value="<?php echo h($_POST['mainCat']);?>"><?php echo h($_POST['mainCat']);?></option>
                <?php else : ?>
                  <option value="">Выберите категорию</option>
                <?php endif;?>
              </select>
        
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
                <select class="select" name="subCat" id="subCat">
                  <option value="">Выберите подкатегорию</option>
                </select>
    

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
                <option value="">Выберите бренд</option>
              </select>
    
              <a 
                class="button button--s button--primary" 
                href="<?php echo HOST . 'brand-new';?>">
                  Новый бренд
              </a>
            </div>
        </div>

        <div class="admin-form__field">
          <label class="admin-form__text" for="editor">Описание товара</label>
          <textarea class="admin-form__textarea" placeholder="Введите описание товара" name="content" rows="5" cols="1" id="editor">
            <?php echo isset($_POST['content']) ? h($_POST['content']) : 'Введите описание товара'; ?>
          </textarea>
        </div>
      </div>

      <div class="admin-form__column admin-form__column--imgs">
        <div class="admin-form__field">
    
          <label class="admin-form__label">Фотографии товара</label>
          <div class="block-upload" data-preview="block">
            <div class="block-upload__description">
              <p class="block-upload__title">
                Изображение jpg или png, рекомендуемая ширина 945px и больше, высота от 400px и более. Вес до 2Мб.
              </p>
            </div>

            <div class="block-upload__button">
              <label class="block-upload__input-fake" for="file">Выбрать изображения</label>
              <input id="file" name="cover[]" class="block-upload__input-real" type="file" multiple data-preview="input">
            </div>

            <div class="block-upload__preview" data-preview="container" data-dragg-and-drop></div>
          </div>
         
        </div>
      </div>
    </div>

    <!-- CSRF-токен -->
    <input type="hidden" name="csrf" value="<?php echo h(csrf_token()) ;?>">

    <div class="admin-form__button-wrapper admin-form__button-row">
      <a class="button button--m button--outline" href="<?php echo HOST . 'admin/shop';?>">Отмена</a>
      <button class="button button--m button--primary" type="submit" name="submit" value="submit">Опубликовать</button>
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
