<header class="authorization-page__header">
  <a class="authorization-page__link" href="{{ config('app.url') }}">
    <h2 class="authorization-page__header-title">vvintage.ru</h2>
    <p class="authorization-page__header-subtitle">
      {{ __('auth.page.slogan', [], 'auth') }}
    </p>
  </a>
  
  <div class="authorization-page__lang"> 
    @include ('components.select.select-lang')
  </div> 

</header>

<main class="inner-page">
  <section class="authorization">
    <div class="container">
      <div class="authorization__content">
          <div class="authorization__forms-wrapper">
            @yield('content')
          </div>
      </div>
    </div>
  </section>
  <div class="background animation-bg">
    @include ('components.animations.background-lines')
  </div>  
</main>