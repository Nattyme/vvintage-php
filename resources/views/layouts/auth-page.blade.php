<header class="authorization-page__header">
  <a class="authorization-page__link" href="<?php/* echo HOST;*/ ?>">
    <h2 class="authorization-page__header-title">vvintage.ru</h2>
    <p class="authorization-page__header-subtitle">
      <?php echo h(__('auth.page.slogan', [], 'auth')) ;?>
    </p>
  </a>
  
  <!-- <div class="authorization-page__lang">
    <?php include ROOT . 'views/components/select/_select-lang.tpl';?>
  </div> -->

</header>

<main class="inner-page">
  <section class="authorization">
    <div class="container">
      <div class="authorization__content">
          <div class="authorization__forms-wrapper">
            {{ $content }}
          </div>
      </div>
    </div>
  </section>
  <div class="background animation-bg">
    <?php include ROOT. 'views/components/animations/_background-lines.tpl';?>
  </div>  
</main>