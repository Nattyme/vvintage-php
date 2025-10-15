<script src="<?php echo HOST;?>libs/ckeditor/ckeditor.js"></script>

<div class="admin-page__content-form">
  <div hidden class="notifications">
    <div class="notifications__title"></div>
  </div>

  <?php include ROOT . 'views/admin/blog/_parts/_form-edit.tpl';?>
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
