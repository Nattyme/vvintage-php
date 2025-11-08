@extends('layout.auth-page') {{-- говорим, что используем layout.blade.php --}}

@section('content')
  <form class="authorization-form" method="POST" name="formLogin" action="{{ route('login') }}">
    <div class="authorization-form__heading">
      <h2 class="heading">
        <?php echo h(__('auth.login.tooltip', [], 'auth'));?>
      </h2>
    </div>
    
    @include ('components.notifications.error')
    @include ('components.notifications.success')

    @csrf

    @if empty($_SESSION['success'])
      <div class="authorization-form__field">
        <lable for="email" class="authorization-form__field-title">
          <?php echo h(__('auth.label.email', [], 'auth'));?>
        </lable>
        <input 
          id="email"
          name="email" 
          class="input" 
          value="<?php echo isset($_POST['email']) ? trim($_POST['email']) : ''; ?>" 
          type="email" 
          placeholder="<?php echo h(__('auth.placeholder.email', [], 'auth'));?>" 
          required 
        />
      </div>

      <div class="authorization-form__field">
        <label for="password" class="authorization-form__field-title">
          <?php echo h(__('auth.label.password', [], 'auth'));?>
        </label>

        <input 
          id="password" 
          name="password" 
          class="input" 
          value="" 
          type="password" 
          placeholder="<?php echo h(__('auth.placeholder.password', [], 'auth'));?>" 
          required 
        />
      </div>

      <div class="authorization-form__button">
        <button name="login" value="login" type="submit" class="button button--m button--primary button--with-icon">
          <?php echo h(__('auth.action.enter', [], 'auth'));?>
        </button>
      </div>

      {{-- Разделитель с линиями и текстом "или" --}}
      <div class="divider">
        <span>
          <?php echo h(__('auth.page.ways.separator', [], 'auth'));?>
        </span>
      </div>

      <!-- google button -->
      @include ('components.buttins.google-button', ['text' => __('auth.page.login.google', [], 'auth') ])

      {{-- CSRF-токен --}}
      <input type="hidden" name="csrf" value="<?php echo h(csrf_token()) ;?>">
      <!-- // CSRF-токен -->
    @endif
  </form>

  {{-- links --}}
  <div class="authorization__links">
    <h2 class="authorization__subtitle">
      <?php echo h(__('auth.tooltip.not_registered', [], 'auth'));?>
    </h2>
    <div class="authorization-form__button">
      <a href="<?php echo HOST; ?>registration" class="button button--m button--outline button--outline-transparent button--with-icon">
        <?php echo h(__('auth.register.profile', [], 'auth'));?>
      </a>
    </div>

    <div class="authorization-form__button">
      <a href="<?php echo HOST; ?>lost-password" class="button button--m button--outline button--outline-transparent button--with-icon">
        <?php echo h(__('auth.restore.password', [], 'auth'));?>
      </a>
    </div>

    
  </div>
   {{-- links --}}
@endsection
  