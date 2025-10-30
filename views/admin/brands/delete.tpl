<div class="admin-page__content-form">
  
  <?php include ROOT . "views/components/errors.tpl"; ?>
  <?php include ROOT . "views/components/success.tpl"; ?>

  <form class="admin-form" method="POST" action="<?php echo HOST;?>admin/brand-delete/<?php echo u($brand->id); ?>">
    <div class="admin-form__title">
      <p class="h2">Вы действительно хотите удалить бренд: <span class="text-bold">"<?php echo h($brand->title);?>"?</span></p>  
    </div>

    <!-- CSRF-токен -->
    <input type="hidden" name="csrf" value="<?php echo h(csrf_token()) ;?>">

    <div class="admin-form__buttons buttons">
      <a class="button button--outine button--s" href="<?php echo HOST . 'admin/brand';?>">Отмена</a>
      <button name="submit" value="submit" class="button button--primary button--s" type="submit">Удалить</button>
    </div>
  </form>
</div>



