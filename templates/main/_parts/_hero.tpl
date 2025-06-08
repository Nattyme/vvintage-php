<section class="hero">
  <div class="hero__block">
    <div class="hero__background">
      <div class="hero__img-wrapper">
        <picture>
          <source srcset="<?php echo HOST . 'static/img/hero/01.webp 1x,' . 'static/img/hero/01@2x.webp 2x';?>" type="image/webp" />
          <source srcset="<?php echo HOST . 'static/img/hero/01.jpg 1x,' . 'static/img/hero/01@2x.jpg 2x';?>" type="image/jpeg" />
          <img class="hero__img" src="<?php echo HOST . 'static/img/hero/01.jpg';?>" srcset="<?php echo HOST . 'static/img/hero/01@2x.jpg';?>" alt="" />
        </picture>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="hero__content-wrapper">
      <div class="hero__text">
        <div class="hero__title">
          <h1 class="h1"><?php echo h($main['hero_title']);?></h1>
        </div>
        <div class="hero__desc">
          <p><?php echo h($main['hero_text']);?>&#8230;</p>
        </div>
      </div>
      <a href="<?php echo HOST;?>shop" class="hero__button">
        <span class="button button--l button--primary">Открыть магазин</span>
      </a>
    </div>
  </div>
</section>
