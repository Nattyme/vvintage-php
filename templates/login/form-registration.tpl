<form class="authorization-form authorization-form--registration" name="formRegistration" method="POST" action="<?php echo HOST; ?>registration">
  <div class="authorization-form__heading">
    <h2 class="heading">Регистрация</h2>
  </div>

  <?php include ROOT . "templates/components/errors.tpl"; ?>
  <?php include ROOT . "templates/components/success.tpl"; ?>

  <div class="authorization-form__field">
    <p class="authorization-form__field-title">Email</p>

    <input 
      value="<?php echo isset($_POST['email']) ? trim($_POST['email']) : ''; ?>"
      name="email" 
      class="input" 
      type="text" 
      placeholder="Введите email" 
    />
  </div>

  <div class="authorization-form__field">
    <p class="authorization-form__field-title">Пароль</p>

    <input name="password" class="input" type="password" placeholder="Введите пароль" />
  </div>

  <div class="authorization-form__button">
    <button name="register" value="register" type="submit" class="button button--with-icon button-primary">
      Отправить
    </button>
  </div>
</form>

<div class="authorization__links">
  <h2 class="authorization__subtitle">Зарегестрированы?</h2>
  <div class="authorization__img">
    <svg class="icon icon--woman-with-hat">
      <use href="./img/svgsprite/sprite.symbol.svg#woman-with-hat"></use>
    </svg>
  </div>

  <div class="authorization-form__button">
    <a href="<?php echo HOST.'login'; ?>" class="button button--with-icon button-primary-outline">Войти</a>
  </div>
</div>
