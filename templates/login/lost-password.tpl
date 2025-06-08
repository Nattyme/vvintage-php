<form class="authorization-form authorization-form--lost-pass" name="formLostPass" method="POST" action="">
  <div class="authorization-form__heading">
    <h2 class="heading">Восстановить пароль</h2>
  </div>

  <?php include ROOT . "templates/components/errors.tpl"; ?>
  <?php include ROOT . "templates/components/success.tpl"; ?>

  <?php if (!isset($resultEmail)) : ?>
  <div class="authorization-form__field">
    <label for="email" class="authorization-form__field-title">Email</label>
    <input name="email" class="input" type="text" placeholder="Введите ваш Email" id="email"/>
  </div>
  
  <!-- CSRF-токен -->
    <input type="hidden" name="csrf" value="<?php echo h(csrf_token()) ;?>">
  <!-- // CSRF-токен -->

  <div class="authorization-form__button">
    <button name="lost-password" value="lost-password" type="submit" class="button button--l button--primary button--with-icon">Восстановить</button>
  </div>
  <?php endif; ?>
</form>

<!-- links -->
<div class="authorization__links">
  <div class="authorization-form__button">
    <a href="<?php echo HOST; ?>registration" class="button button--m button--outline button--outline-transparent button--with-icon">Регистрация</a>
  </div>
  <div class="authorization-form__button">
    <a href="<?php echo HOST; ?>login" class="button button--m button--outline button--outline-transparent button--with-icon">Войти</a>
  </div>
</div>
<!-- // links -->