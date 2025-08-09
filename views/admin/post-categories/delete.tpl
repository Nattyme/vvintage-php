<div class="admin-page__content-form">
  
  <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
  <?php include ROOT . "admin/templates/components/success.tpl"; ?>

  <form class="admin-form" method="POST" action="<?php echo HOST;?>admin/category-delete?id=<?php echo u($cat['id']); ?>">
    <div class="admin-form__title">
      <p class="h2">Вы действительно хотите удалить категорию: <span class="text-bold">"<?php echo h($cat['title']);?>"?</span></p>  
    </div>

    <!-- CSRF-токен -->
    <input type="hidden" name="csrf" value="<?php echo h(csrf_token()) ;?>">

    <div class="admin-form__buttons buttons">
      <button name="submit" value="submit" class="button-solid button-solid--admin" type="submit">
        Удалить
      </button>
      <a class="button-outline button-outline--admin" href="<?php echo HOST . 'admin/category';?>">Отмена</a>
    </div>
  </form>
</div>

