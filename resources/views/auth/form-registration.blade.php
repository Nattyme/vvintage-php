<form class="authorization-form authorization-form--registration" name="formRegistration" method="POST" action="<?php echo HOST; ?>registration">
  <div class="authorization-form__heading">
    <h2 class="heading">
      <?php echo h(__('auth.register.profile', [], 'auth'));?>
    </h2>
  </div>

  @include ('components.notifications.error')
  @include ('components.notifications.success')

  @csrf

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
      <?php echo h(__('button.submit', [], 'buttons'));?>
    </button>
  </div>

  
  {{-- Разделитель с линиями и текстом "или" --}}
  <div class="divider">
    <span>
      <?php echo h(__('auth.page.ways.separator', [], 'auth'));?>
    </span>
  </div>

  <!-- google button -->
  @include ('components.buttins.google-button', ['text' =>  h(__('auth.page.login.google', [], 'auth')) ])
</form>

<!-- links -->
<div class="authorization__links">
  <h2 class="authorization__subtitle">
    <?php echo h(__('auth.tooltip.registered', [], 'auth')) ;?>
  </h2>

  <div class="authorization-form__button">
    <a href="<?php echo HOST.'login'; ?>" class="button button--m button--outline button--outline-transparent button--with-icon">
      <?php echo h(__('auth.action.enter', [], 'auth')) ;?>
    </a>
  </div>
  <div class="authorization-form__button">
    <a href="<?php echo HOST . 'lost-password';?>" class="button button--m button--outline button--outline-transparent button--with-icon">
       <?php echo h(__('auth.restore.password', [], 'auth')) ;?>
    </a>
  </div>
</div>
<!-- // links -->