<div class="admin-page__content-form">
  <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
  <?php include ROOT . "admin/templates/components/success.tpl"; ?>

  <form 
    class="admin-form" 
    method="POST" action="<?php echo HOST . 'admin/shop-delete?id=' . u($product['id']); ?>"
  >
    <div class="admin-form__field">
      <p class="h2">Вы действительно хотите удалить товар?</p>
      <p><strong>id: </strong><?php echo h($product['id']);?></p>
      <p><strong>Название: </strong><?php echo h($product['title']);?></p>
    </div>

    <!-- CSRF-токен -->
    <input type="hidden" name="csrf" value="<?php echo h(csrf_token()) ;?>">

    <div class="admin-form__item buttons">
      <button name="submit" value="submit" class="button button--m button--primary button--warning" type="submit">Удалить</button>
      <a class="button button--m button--outline" href="<?php echo HOST . 'admin/shop';?>">Отмена</a>
    </div>
  </form>
</div>

