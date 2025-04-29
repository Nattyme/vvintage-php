<script src="<?php echo HOST;?>libs/ckeditor/ckeditor.js"></script>

<div class="admin-page__content-form">
  
  <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
  <?php include ROOT . "admin/templates/components/success.tpl"; ?>

  <form class="admin-form" 
        method="POST" 
        action="<?php echo HOST;?>admin/contacts">

    <div class="admin-form__item">
      <h2 class="heading">Редактировать контакты</h2>
    </div>

    <!-- about -->
    <?php include ROOT . 'admin/templates/contacts/parts/about.tpl' ;?>
    <!-- Services -->
    <?php include ROOT . 'admin/templates/contacts/parts/services.tpl' ;?>
    <?php include ROOT . 'admin/templates/contacts/parts/contacts.tpl' ;?>

    <div class="admin-form__item buttons">
      <button name="submit" value="postEdit" class="primary-button" type="submit">Сохранить изменения</button>
      <a class="secondary-button" href="<?php echo HOST;?>admin">Отмена</a>
    </div>
    
  </form>
</div>

<script>
  CKEDITOR.replace('about_text', {
    filebrowserUploadMethod: 'form',
    filebrowserUploadUrl: '<?php echo HOST;?>libs/ck-upload/upload.php'
  });
</script>
<script>
  CKEDITOR.replace('services_text', {
    filebrowserUploadMethod: 'form',
    filebrowserUploadUrl: '<?php echo HOST;?>libs/ck-upload/upload.php'
  });
</script>
<script>
  CKEDITOR.replace('contacts_text', {
    filebrowserUploadMethod: 'form',
    filebrowserUploadUrl: '<?php echo HOST;?>libs/ck-upload/upload.php'
  });
</script>
