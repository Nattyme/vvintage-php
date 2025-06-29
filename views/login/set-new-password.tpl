<form class="authorization-form authorization-form--lost-pass" name="formLostPass" method="POST" action="">
  <div class="authorization-form__heading">
    <h2 class="heading">Установить новый пароль</h2>
  </div>

  <?php include ROOT . "templates/components/errors.tpl"; ?>
  <?php include ROOT . "templates/components/success.tpl"; ?>

  <?php if( !isset($newPasswordReady) ) : ?>
  <div class="authorization-form__field">
    <label for="password" class="authorization-form__field-title">Новый пароль</label>
    <input name="password" class="input" type="password" placeholder="Введите новый пароль" id="password"/>
  </div>

  <input type="hidden" name="email" value="<?php echo h($_GET['email']); ?>">
  <input type="hidden" name="resetCode" value="<?php echo h($_GET['code']); ?>">

  <div class="authorization-form__button">
    <button name="set-new-password" value="set-new-password" class="button button--l button--primary button--with-icon" type="submit">
      Установить пароль
    </button>
  </div>
  <?php endif; ?>
</form>

<!-- links -->
<div class="authorization__links">
  <div class="authorization-form__button">
    <a href="<?php echo HOST; ?>registration" class="button button--m button--outline button--outline-transparent button--with-icon">Регистрация</a>
  </div>
  <div class="authorization-form__button">
    <a href="<?php echo HOST; ?>login" class="button button--m button--outline button--outline-transparent button--with-icon">Войти на сайт</a>
  </div>
</div>
<!-- // links -->

