<div class="header__main-panel header__top--blog">
  <div class="container">
    <div class="header__row">

      <!-- Логотип -->
      <div class="blog-logo">
        <div class="blog-logo__title"><?php echo h($settings['site_title']); ?></div>
        <span class="blog-logo__separator"></span>
        <div class="blog-logo__text"> <?php echo h(__('blog.title', [], 'blog'));?></div>
      </div>
  

      <!-- Навигация -->
      <div class="header__tools">

        <ul class="menu">
          <li class="menu__item"><a href="<?php echo HOST . 'shop'; ?>">
              <?php echo h(__('blog.backto.shop', [], 'blog'));?>
          </a></li>
          <li class="menu__item"><a href="<?php echo HOST . 'contacts'; ?>">
            <?php echo h(__('blog.cta.contact.us', [], 'blog'));?>
          </a></li>
        </ul>
          <ul class="social-list">
            <li>
              <a href="">
                  <svg class="icon icon--zen">
                    <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#zen'; ?>"></use>
                  </svg>
              </a>
            </li>
          
          </ul>
      </div>
    
      <!-- Бургер -->
      <button class="mobile-nav-btn"><div class="nav-icon"></div></button>

    </div>
  </div>
</div>

