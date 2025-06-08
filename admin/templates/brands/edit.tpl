<div class="admin-page__content-form">
  
  <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
  <?php include ROOT . "admin/templates/components/success.tpl"; ?>

  <form class="admin-form" method="POST" action="<?php echo HOST;?>admin/brand-edit?id=<?php echo u($_GET['id']);?>">
    <div class="admin-form__field">
      <label class="admin-form__label" for="title">Название бренда</label>
      <input 
        id="title"
        name="title" 
        class="admin-form__input admin-form__input--width-label" 
        type="text" 
        placeholder="Заголовок бренда" 
        value="<?php echo h(trim($brand['title']));?>"
      />
    </div>

    <!-- CSRF-токен -->
    <input type="hidden" name="csrf" value="<?php echo h(csrf_token()) ;?>">

    <div class="admin-form__buttons buttons">
      <button name="submit" value="submit" class="button-solid button-solid--admin" type="submit">Сохранить изменения</button>
      <a class="button-outline button-outline--admin" href="<?php echo HOST;?>admin/brand" title="К списку брендов">К списку брендов</a>
    </div>
  </form>
</div>

