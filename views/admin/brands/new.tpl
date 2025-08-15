<div class="admin-page__content-form">
  
  <?php include ROOT . "views/components/errors.tpl"; ?>
  <?php include ROOT . "views/components/success.tpl"; ?>

  <form class="admin-form" method="POST" action="<?php echo HOST;?>admin/brand-new">
    <div class="admin-form__field">
      <label class="admin-form__label" for="title">Введите название бренда</label>
      <input 
        id="title" 
        name="title" 
        class="admin-form__input admin-form__input--width-label" 
        type="text" 
        placeholder="Заголовок бренда" 
        value="<?php echo isset($_POST['title']) ? h($_POST['title']) : '';?>"
      />
    </div>

    <!-- CSRF-токен -->
    <input type="hidden" name="csrf" value="<?php echo h(csrf_token()) ;?>">

    <div class="admin-form__buttons buttons">
      <button name="submit" value="submit" class="button button--m button--primary" type="submit">Создать</button>
      <a class="button button--m button--outline" href="<?php echo HOST . 'admin/brand';?>">Отмена</a>
    </div>
  </form>
</div>

