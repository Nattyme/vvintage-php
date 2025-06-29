<form class="authorization-form authorization-form--registration" name="formRegistration" method="POST" action="<?php echo HOST; ?>registration">
  <div class="authorization-form__heading">
    <h2 class="heading">Регистрация</h2>
  </div>

  <?php include ROOT . "templates/components/errors.tpl"; ?>
  <?php include ROOT . "templates/components/success.tpl"; ?>

  <div class="authorization-form__field">
    <label for="email" class="authorization-form__field-title">Email</label>

    <input 
      id="email"
      class="input" 
      name="email" 
      type="text" 
      value="<?php echo isset($_POST['email']) ? h(trim($_POST['email'])) : ''; ?>"
      placeholder="Введите email" 
    />
  </div>

  <div class="authorization-form__field">
    <label for="password" class="authorization-form__field-title">Пароль</label>

    <input 
      id="password"
      name="password" 
      class="input" 
      type="password" 
      placeholder="Введите пароль" 
    />
  </div>

  <!-- CSRF-токен -->
    <input type="hidden" name="csrf" value="<?php echo h(csrf_token()) ;?>">
  <!-- // CSRF-токен -->

  <div class="authorization-form__button">
    <button name="register" value="register" type="submit" class="button button--l button--primary button--with-icon">
      Отправить
    </button>
  </div>
</form>

<!-- links -->
<div class="authorization__links">
  <h2 class="authorization__subtitle">Зарегестрированы?</h2>

  <div class="authorization-form__button">
    <a href="<?php echo HOST.'login'; ?>" class="button button--m button--outline button--outline-transparent button--with-icon">Войти</a>
  </div>
  <div class="authorization-form__button">
    <a href="<?php echo HOST . 'lost-password';?>" class="button button--m button--outline button--outline-transparent button--with-icon">
      Восстановить
    </a>
  </div>
</div>
<!-- // links -->