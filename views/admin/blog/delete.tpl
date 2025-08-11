<div class="admin-page__content-form">
  <?php include ROOT . "views/components/errors.tpl"; ?>
  <?php include ROOT . "views/components/success.tpl"; ?>

  <form 
    class="admin-form" 
    method="POST" 
    action="<?php echo HOST . 'admin/post-delete?id=' . h($post->getId()); ?>" 
    enctype="multipart/form-data"
  >
    <div class="admin-form__field">
      <p class="h2">Вы действительно хотите удалить пост?</p>
      <p><strong>id: </strong><?php echo h($post->getId());?></p>
      <p><strong>Название: </strong><?php echo h($post->getTitle());?></p>
    </div>

    <div class="admin-form__buttons buttons">
      <button name="postDelete" value="postDelete" class="button button--m button--danger " type="submit">Удалить</button>
      <a class="button button--m button--outline" href="<?php echo HOST . 'admin/blog';?>">Отмена</a>
    </div>
  </form>
</div>

