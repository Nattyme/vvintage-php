<script src="<?php echo HOST;?>libs/ckeditor/ckeditor.js"></script>

<div class="admin-page__content-form">
  <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
  <?php include ROOT . "admin/templates/components/success.tpl"; ?>

  <form class="admin-form" 
        method="POST" 
        action="<?php echo HOST;?>admin/post-edit?id=<?php echo $post['id']; ?>" enctype="multipart/form-data">

    <div class="admin-form__item">
      <h2 class="heading">Редактировать пост</h2>
    </div>
    <div class="admin-form__item">
      <label class="input__label">
        Введите название записи 
        <input name="title" 
               class="input input--width-label" 
               type="text" 
               placeholder="Заголовок поста" 
               value="<?php echo $post['title']; ?>"
        />
      </label>
    </div>
    <div class="admin-form__item">
      <label class="select-label">Выберите категорию 
        <select class="select" name="cat">
          <?php foreach ($cats as $cat) : ?>
            <option 
              <?php echo $post['cat'] == $cat['id'] ? 'selected' : '';?> 
              value=<?php echo $cat['id'];?>><?php echo $cat['title'];?>
            </option>
          <?php endforeach; ?>
        </select>
      </label>
    </div>
    <div class="admin-form__item">
      <label class="textarea__label mb-15" name="editor">
        Содержимое поста 
      </label>
      <textarea name="content" class="textarea textarea--width-label" placeholder="Введите текст" id="editor">
        <?php echo $post['content'] ;?>
      </textarea>
    </div>
    <div class="admin-form__item">
      <div class="block-upload">
        <div class="block-upload__description">
          <div class="block-upload__title">Обложка поста:</div>
          <p>Изображение jpg или png, рекомендуемая ширина 945px и больше, высота от 400px и более. Вес до 2Мб.</p>
          <div class="block-upload__file-wrapper">
            <input name="cover" class="file-button" type="file">
          </div>
        </div>
        <?php if (!empty($post->cover)) : ?>
          <div class="block-upload__img">
            <img src="<?php echo HOST . 'usercontent/blog/' . $post['coverSmall'];?>" alt="Загрузка картинки" />
          </div>
          <label class="checkbox__item mt-15">
            <input class="checkbox__btn" type="checkbox" name="delete-cover">
            <span class="checkbox__label">Удалить обложку</span>
          </label>
        <?php endif;?>
      </div>
    </div>

    <div class="admin-form__item buttons">
      <button name="postEdit" value="postEdit" class="primary-button" type="submit">Сохранить изменения</button>
      <?php if (isset($_POST['postEdit'])) : ?>
        <a class="secondary-button" href="<?php echo HOST;?>admin/blog" title="К списку записей">К списку записей</a>
      <?php else : ?>
        <a class="secondary-button" href="<?php echo HOST;?>admin/blog" title="Отмена">Отмена</a>
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
