<script src="<?php echo HOST;?>libs/ckeditor/ckeditor.js"></script>

<div class="admin-page__content-form">
  <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
  <?php include ROOT . "admin/templates/components/success.tpl"; ?>

  <form class="admin-form" 
        method="POST" 
        action="<?php echo HOST . 'admin/post-edit?id=' . u($post['id']); ?>" enctype="multipart/form-data">

    <div class="admin-form__field">
      <label class="admin-form__label" for="title">Введите название записи</label> 
      <input name="title" 
             class="input input--width-label" 
             type="text" 
             placeholder="Заголовок поста" 
             value="<?php echo h($post['title']); ?>"
      />
    </div>

    <div class="admin-form__field">
      <label class="admin-form__label" for="description">Введите краткое описание</label> 
      <input id="description"
             name="description" 
             class="input" 
             type="text" 
             placeholder="Описание поста" 
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
          <a class="button button--s button--primary" href="<?php echo HOST . 'admin/category-blog-new';?>">Создать</a>
        </div>
    </div>

    <div class="admin-form__field">
      <label class="admin-form__label" name="editor" for="content">Содержимое поста </label>
      <textarea name="content" class="textarea textarea--width-label" placeholder="Введите текст" id="editor">
        <?php echo $post['content'] ;?>
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
        <?php if (!empty($post->cover)) : ?>
          <div class="block-upload__img block-upload__img--with-checkbox">
            <img src="<?php echo HOST . 'usercontent/blog/' . $post['coverSmall'];?>" alt="Загрузка картинки" />
            <div class="block-upload__checkbox">
         
              <label class="admin-form__label admin-form__label--with-checkbox">
                <input class="table__checkbox-hidden real-checkbox" type="checkbox" name="delete-cover" id="delete-cover">
                <span class="table__checkbox-fake custom-checkbox"></span>
                Удалить обложку
              </label>
            </div>
          </div>
        <?php endif;?>
      </div>
    </div>

  
    <div class="admin-form__buttons buttons">
      <?php if (isset($_POST['postEdit'])) : ?>
        <a class="button button--m button--outline" href="<?php echo HOST . 'admin/blog';?>" title="К списку записей">К списку записей</a>
      <?php else : ?>
        <a class="button button--m button--outline" href="<?php echo HOST . 'admin/blog';?>" title="Отмена">Отмена</a>
      <?php endif; ?>
      <button name="postEdit" value="postEdit" class="button button--m button--primary" type="submit">Сохранить изменения</button>
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
