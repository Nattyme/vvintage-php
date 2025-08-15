<header class="authorization-page__header">
  <a class="authorization-page__link" href="<?php echo HOST; ?>">
    <h2 class="authorization-page__header-title">vvintage.ru</h2>
    <p class="authorization-page__header-subtitle">
      <?php echo h(__('auth.page.slogan', [], 'auth')) ;?>
    </p>
  </a>
  
  <div class="authorization-page__lang">
    <?php include ROOT . 'views/_parts/_parts-header/_select-lang.tpl';?>
  </div>

</header>

<main class="inner-page">
  <section class="authorization">
    <div class="container">
      <div class="authorization__content">
          <div class="authorization__forms-wrapper">
            <?php echo $content; ?>
          </div>
      </div>
    </div>
  </section>
</main>
