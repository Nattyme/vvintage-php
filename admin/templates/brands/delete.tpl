<div class="admin-page__content-form">
  
  <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
  <?php include ROOT . "admin/templates/components/success.tpl"; ?>

  <form class="admin-form" method="POST" action="<?php echo HOST;?>admin/brand-delete?id=<?php echo u($brand['id']); ?>">
    <div class="admin-form__item admin-form__title">
      <h2 class="heading">Удалить бренд</h2>
    </div>
    <div class="admin-form__item">
      <p>Вы действительно хотите удалить бренд <strong>"<?php echo h($brand['title']);?>"</strong>?</p>  
    </div>

    <!-- CSRF-токен -->
    <input type="hidden" name="csrf" value="<?php echo h(csrf_token()) ;?>">

    <div class="admin-form__item admin-form__item--buttons">
      <button name="submit" value="submit" class="button-solid button-solid--admin" type="submit">
        Удалить
      </button>
      <a class="button-outline button-outline--admin" href="<?php echo HOST . 'admin/brand';?>">Отмена</a>
    </div>
  </form>
</div>

