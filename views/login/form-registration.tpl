<form class="authorization-form authorization-form--registration" name="formRegistration" method="POST" action="<?php echo HOST; ?>registration">
  <div class="authorization-form__heading">
    <h2 class="heading">Регистрация</h2>
  </div>

  <?php include ROOT . "views/components/errors.tpl"; ?>
  <?php include ROOT . "views/components/success.tpl"; ?>

  <div class="authorization-form__field">
    <label for="email" class="authorization-form__field-title">
       <?php echo h(__('auth.label.email', [], 'auth')) ;?>
    </label>

    <input 
      id="email"
      class="input" 
      name="email" 
      type="text" 
      value="<?php echo isset($_POST['email']) ? h(trim($_POST['email'])) : ''; ?>"
      placeholder="<?php echo h(__('auth.placeholder.email', [], 'auth')) ;?>" 
    />
  </div>

  <div class="authorization-form__field">
    <label for="password" class="authorization-form__field-title">
      <?php echo h(__('auth.label.password', [], 'auth')) ;?>
    </label>

    <input 
      id="password"
      name="password" 
      class="input" 
      type="password" 
      placeholder="<?php echo h(__('auth.placeholder.password', [], 'auth')) ;?>" 
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

  
  <!-- Разделитель с линиями и текстом "или" -->
  <div class="divider">
    <span>или</span>
  </div>

  <button class="gsi-material-button">
    <div class="gsi-material-button-state"></div>
    <div class="gsi-material-button-content-wrapper">
      <div class="gsi-material-button-icon">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" xmlns:xlink="http://www.w3.org/1999/xlink" style="display: block;">
          <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path>
          <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path>
          <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"></path>
          <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path>
          <path fill="none" d="M0 0h48v48H0z"></path>
        </svg>
      </div>
      <span class="gsi-material-button-contents">Sign up with Google</span>
      <span style="display: none;">Sign up with Google</span>
    </div>
  </button>
</form>

<!-- links -->
<div class="authorization__links">
  <h2 class="authorization__subtitle">
    <?php echo h(__('auth.tooltip.registered', [], 'auth')) ;?>
  </h2>

  <div class="authorization-form__button">
    <a href="<?php echo HOST.'login'; ?>" class="button button--m button--outline button--outline-transparent button--with-icon">Войти</a>
  </div>
  <div class="authorization-form__button">
    <a href="<?php echo HOST . 'lost-password';?>" class="button button--m button--outline button--outline-transparent button--with-icon">
       <?php echo h(__('auth.restore.password', [], 'auth')) ;?>
    </a>
  </div>
</div>
<!-- // links -->



