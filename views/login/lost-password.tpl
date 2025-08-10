<form class="authorization-form authorization-form--lost-pass" name="formLostPass" method="POST" action="">
  <div class="authorization-form__heading">
    <h2 class="heading">
      <?php echo h(__('auth.restore.password', [], 'auth')) ;?>
    </h2>
  </div>

  <?php include ROOT . "views/components/errors.tpl"; ?>
  <?php include ROOT . "views/components/success.tpl"; ?>

  <?php if (!$resultEmail ) : ?>
  <div class="authorization-form__field">
    <label for="email" class="authorization-form__field-title">
      <?php echo h(__('auth.label.email', [], 'auth')) ;?>
    </label>
    <input 
      name="email" 
      class="input" 
      type="text" 
      placeholder="<?php echo h(__('auth.placeholder.email', [], 'auth')) ;?>" 
      id="email"/>
  </div>
  
  <!-- CSRF-токен -->
    <input type="hidden" name="csrf" value="<?php echo h(csrf_token()) ;?>">
  <!-- // CSRF-токен -->

  <div class="authorization-form__button">
    <button name="lost-password" value="lost-password" type="submit" class="button button--l button--primary button--with-icon">
      <?php echo h(__('auth.restore.password', [], 'auth')) ;?>
    </button>
  </div>
  <?php endif; ?>
</form>

<!-- links -->
<div class="authorization__links">
  <div class="authorization-form__button">
    <a href="<?php echo HOST; ?>registration" class="button button--m button--outline button--outline-transparent button--with-icon">
      <?php echo h(__('auth.register.profile', [], 'auth')) ;?>
    </a>
  </div>
  <div class="authorization-form__button">
    <a href="<?php echo HOST; ?>login" class="button button--m button--outline button--outline-transparent button--with-icon">
       <?php echo h(__('auth.action.enter', [], 'auth')) ;?>
    </a>
  </div>
</div>
<!-- // links -->