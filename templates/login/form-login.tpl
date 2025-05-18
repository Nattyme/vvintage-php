
<form class="authorization-form" method="POST" name="formLogin" action="<?php echo HOST; ?>login">
  <div class="authorization-form__heading">
    <h2 class="heading">Вход</h2>
  </div>
  <?php include ROOT . "templates/components/errors.tpl"; ?>
  <?php include ROOT . "templates/components/success.tpl"; ?>

  <?php if(empty($_SESSION['success'])) : ?>
  <div class="authorization-form__field">
    <lable for="email" class="authorization-form__field-title">Email</lable>
    <input value="info2@mail.ru" type="email" class="input" name="email" value="" placeholder="Введите ваш email" id="email" required />
  </div>

  <div class="authorization-form__field">
    <label for="password" class="authorization-form__field-title">Пароль</label>

    <input value="111111" type="password" class="input" name="password" placeholder="Введите пароль" id="password" required />
  </div>

  <div class="authorization-form__button">
    <button name="login" value="login" type="submit" class="button button--with-icon button-primary">Войти</button>
  </div>
  <?php endif; ?>
</form>

<div class="authorization__links">
  <h2 class="authorization__subtitle">Не&#160;зарегестрированы?</h2>
  <div class="authorization-form__button">
    <a href="<?php echo HOST; ?>registration" class="button button--with-icon button-primary-outline">Регистрация</a>
  </div>

  <div class="authorization-form__button">
    <a href="<?php echo HOST; ?>lost-password" class="button button--with-icon button-primary-outline">
      Восстановить
    </a>
  </div>
</div>

  


