<script src="<?php echo HOST;?>libs/ckeditor/ckeditor.js"></script>

<div class="admin-page__content-form">
  
  <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
  <?php include ROOT . "admin/templates/components/success.tpl"; ?>

  <form class="admin-form" method="POST" action="<?php echo HOST;?>admin/post-new" enctype="multipart/form-data">
    <div class="admin-form__item admin-form__field">
      <label class="input__label">
        Введите название записи 
        <input name="title" class="input" type="text" placeholder="Заголовок поста" 
               value="<?php echo isset($_POST['title']) ? $_POST['title'] : ''; ?>"
        />
      </label>
    </div>
    <div class="admin-form__item admin-form__field">
      <label class="select-label">Выберите категорию 
        <select class="select" name="cat">
          <?php foreach ($cats as $cat) : ?>
            <option value="<?php echo $cat['id'];?>"><?php echo $cat['title'];?></option>
          <?php endforeach; ?>
        </select>
      </label>
    </div>

    <a class="button button-solid" href="<?php HOST;?>category-new?blog">Создать новую категорию</a>
  
    <div class="admin-form__item admin-form__field">
      <label class="textarea__label mb-15" name="editor">
        Содержимое поста 
      </label>
      <textarea name="content" class="textarea textarea--width-label mt-10" placeholder="Введите текст" id="editor">
          <?php echo isset($_POST['content']) ? $_POST['content'] : ''; ?>
      </textarea>
    </div>
    <div class="admin-form__item admin-form__field">
      <div class="block-upload">
        <div class="block-upload__description">
          <div class="block-upload__title">Обложка поста:</div>
          <p>Изображение jpg или png, рекомендуемая ширина 945px и больше, высота от 400px и более. Вес до 2Мб.</p>
          <div class="block-upload__file-wrapper">
            <input name="cover" class="file-button" type="file">
          </div>
        </div>
      </div>
    </div>

    <div class="admin-form__item buttons">
      <a class="buttin button-outline" href="<?php echo HOST;?>admin/blog">Отмена</a>
      <button name="postSubmit" value="postSubmit" class="buttin button-primary" type="submit">
        Опубликовать
      </button>
    
    </div>
  </form>
</div>

<script>
  CKEDITOR.replace('editor', {
    filebrowserUploadMethod: 'form',
    filebrowserUploadUrl: '<?php echo HOST;?>libs/ck-upload/upload.php'
  });
</script>
