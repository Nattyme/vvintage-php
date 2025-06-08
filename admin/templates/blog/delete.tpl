<div class="admin-page__content-form">
  <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
  <?php include ROOT . "admin/templates/components/success.tpl"; ?>

  <form 
    class="admin-form" 
    method="POST" 
    action="<?php echo HOST . 'admin/post-delete?id=' . $post['id']; ?>" 
    enctype="multipart/form-data"
  >
    <div class="admin-form__field">
      <p class="h2">Вы действительно хотите удалить пост?</p>
      <p><strong>id: </strong><?php echo h($post['id']);?></p>
      <p><strong>Название: </strong><?php echo h($post['title']);?></p>
    </div>

    <div class="admin-form__buttons buttons">
      <button name="postDelete" value="postDelete" class="primary-button primary-button--red" type="submit">Удалить</button>
      <a class="button button-outline" href="<?php echo HOST . 'admin/blog';?>">Отмена</a>
    </div>
  </form>
</div>

