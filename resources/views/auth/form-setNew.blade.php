<form class="authorization-form authorization-form--lost-pass" name="formLostPass" method="POST" >
  <div class="authorization-form__heading">
    <h2 class="heading">
      <?php echo h(__('auth.tooltip.set.new_password', [], 'auth')) ;?>
    </h2>
  </div>

  @include ('components.notifications.error')
  @include ('components.notifications.success')

  @csrf

  @if (!$newPasswordReady)
    <div class="authorization-form__field">
      <label for="password" class="authorization-form__field-title"></label>
      <input name="password" class="input" type="password" placeholder="<?php echo h(__('auth.label.new_password', [], 'auth')) ;?>" id="password"/>
    </div>

    <input type="hidden" name="email" value="<?php echo h($_GET['email']); ?>">
    <input type="hidden" name="resetCode" value="<?php echo h($_GET['code']); ?>">

    <div class="authorization-form__button">
      <button name="set-new-password" value="set-new-password" class="button button--m button--primary button--with-icon" type="submit">
        <?php echo h(__('button.save', [], 'buttons')) ;?>
      </button>
    </div>
  @endif
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