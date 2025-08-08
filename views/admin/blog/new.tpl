<script src="<?php echo HOST;?>libs/ckeditor/ckeditor.js"></script>

<div class="admin-page__content-form">
  
  <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
  <?php include ROOT . "admin/templates/components/success.tpl"; ?>

  <form class="admin-form" method="POST" action="<?php echo HOST;?>admin/post-new" enctype="multipart/form-data">

    <div class="admin-form__field">
      <label class="admin-form__label" for="title">Введите название записи</label> 
      <input name="title" class="input" type="text" placeholder="Заголовок поста" id="title"
             value="<?php echo isset($_POST['title']) ? h($_POST['title']) : ''; ?>"
      />
    
    </div>
    
    <div class="admin-form__field">
      <label class="admin-form__label" for="description">Введите краткое описание</label> 
      <input name="description" class="input" type="text" placeholder="Описание поста" id="description"
             value="<?php echo isset($_POST['description']) ? h($_POST['description']) : ''; ?>"
      />
    
    </div>

    <div class="admin-form__field ">
        <label class="admin-form__label" for="cat">Выберите категорию</label>
        <div class="admin-form__row">
          <select class="select" name="cat" id="cat">
            <?php foreach ($cats as $cat) : ?>
              <option value="<?php echo h($cat['id']);?>"><?php echo h($cat['title']);?></option>
            <?php endforeach; ?>
          </select>
          <a class="button button--s button--primary" href="<?php echo HOST;?>admin/category-blog-new">Создать</a>
        </div>
    </div>


    <div class="admin-form__field">
      <label class="admin-form__label" for="editor">Содержимое поста</label>
      <textarea name="content" class="textarea textarea--width-label mt-10" placeholder="Введите текст" id="editor">
          <?php echo isset($_POST['content']) ? $_POST['content'] : ''; ?>
      </textarea>
    </div>

    <div class="admin-form__field">
      <div class="block-upload">
        <div class="block-upload__description">
          <label class="admin-form__label block-upload__title" for="cover">Обложка поста:</label>
          <p>Изображение jpg или png, рекомендуемая ширина 945px и больше, высота от 400px и более. Вес до 2Мб.</p>
          <div class="block-upload__file-wrapper">
            <input name="cover" class="file-button" type="file">
          </div>
        </div>
      </div>
    </div>

    <div class="admin-form__buttons buttons">
      <a class="button button--m button--outline" href="<?php echo HOST . 'admin/blog';?>">Отмена</a>
      <button name="postSubmit" value="postSubmit" class="button button--m button--primary" type="submit">Опубликовать</button>
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
