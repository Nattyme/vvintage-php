<main class="page-blog__body">
  <section class="post">
    <article class="post__body">
      <div class="post__title">
        <h1 class="h1"><?php echo $post['title'];?></h1>
      </div>

      <!-- image -->
      <?php if (!empty($post['cover'])) : ?>
        <div class="post__img">
          <img src="<?php echo HOST . "usercontent/blog/{$post['cover']}";?>" alt="<?php echo $post['title'];?>" />
        </div>
      <?php endif; ?>
      <!-- // image -->

      <!-- meta -->
      <ul class="post-meta post-meta--with-text">
        <li class="post-meta__readtime post-meta__readtime--with-text">
          <svg class="icon icon--calendar">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#calendar';?>"></use>
          </svg>

          <div class="post-meta__item">
            <p class="post-meta__text">На чтение</p>
            <p class="post-meta__counter">1 мин.</p>
          </div>
        
        </li>
        <li class="post-meta__views post-meta__views--with-text">
          <svg class="icon icon--eye">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#eye';?>"></use>
          </svg>
          <div class="post-meta__item">
            <p class="post-meta__text">Просмотров</p>
            <span class="post-meta__counter">22</span>
          </div>
        </li>
        <li class="post-meta__date post-meta__date--with-text">
    
          <svg class="icon icon--calendar">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#calendar';?>"></use>
          </svg>
          <div class="post-meta__item">
            <p class="post-meta__text">Опубликовано</p>
            <time datetime="2025-05-28"><?php echo h(rus_date("j F Y", $post['timestamp']));?></time>
          </div>
        </li>
      </ul>
      <!-- meta -->
   
      <div class="post__content">
        <!-- Как применить здесь Htmlspecialchair? Здесь вывод из эдитора -->
        <?php echo $post['content'];?>
      </div>
    </article>
  </section>
</main>