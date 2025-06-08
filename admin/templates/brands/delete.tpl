<div class="admin-page__content-form">
  
  <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
  <?php include ROOT . "admin/templates/components/success.tpl"; ?>

  <form class="admin-form" method="POST" action="<?php echo HOST;?>admin/brand-delete?id=<?php echo u($brand['id']); ?>">
    <div class="admin-form__title">
      <p class="h2">Вы действительно хотите удалить бренд <strong>"<?php echo h($brand['title']);?>"</strong>?</p>  
    </div>

    <!-- CSRF-токен -->
    <input type="hidden" name="csrf" value="<?php echo h(csrf_token()) ;?>">

    <div class="admin-form__buttons buttons">
      <a class="button-outline button-outline--admin" href="<?php echo HOST . 'admin/brand';?>">Отмена</a>
      <button name="submit" value="submit" class="button-solid button-solid--admin" type="submit">Удалить</button>
    </div>
  </form>
</div>

