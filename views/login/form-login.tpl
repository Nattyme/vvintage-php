
<form class="authorization-form" method="POST" name="formLogin" action="<?php echo HOST; ?>login">
  <div class="authorization-form__heading">
    <h2 class="heading">Вход</h2>
  </div>
  <?php include ROOT . "templates/components/errors.tpl"; ?>
  <?php include ROOT . "templates/components/success.tpl"; ?>

  <?php if(empty($_SESSION['success'])) : ?>
    <div class="authorization-form__field">
      <lable for="email" class="authorization-form__field-title">Email</lable>
      <input 
        id="email"
        name="email" 
        class="input" 
        value="info2@mail.ru" 
        type="email" 
        placeholder="Введите ваш email" 
        required 
      />
    </div>

    <div class="authorization-form__field">
      <label for="password" class="authorization-form__field-title">Пароль</label>

      <input 
        id="password" 
        name="password" 
        class="input" 
        value="111111" 
        type="password" 
        placeholder="Введите пароль" 
        required 
      />
    </div>

    <div class="authorization-form__button">
      <button name="login" value="login" type="submit" class="button button--l button--primary button--with-icon">Войти</button>
    </div>

    <!-- CSRF-токен -->
      <input type="hidden" name="csrf" value="<?php echo h(csrf_token()) ;?>">
    <!-- // CSRF-токен -->
  <?php endif; ?>
</form>

<!-- links -->
<div class="authorization__links">
  <h2 class="authorization__subtitle">Не&#160;зарегестрированы?</h2>
  <div class="authorization-form__button">
    <a href="<?php echo HOST; ?>registration" class="button button--m button--outline button--outline-transparent button--with-icon">Регистрация</a>
  </div>

  <div class="authorization-form__button">
    <a href="<?php echo HOST; ?>lost-password" class="button button--m button--outline button--outline-transparent button--with-icon">
      Восстановить
    </a>
  </div>
</div>
<!-- // links -->
  


