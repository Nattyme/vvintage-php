<main class="page-blog__post">

  <section class="post">
    <div class="post__content">
      <div class="post__title">
        <h1 class="h1"><?php echo $post['title'];?></h1>
      </div>
   
      <?php if (!empty($post['cover'])) : ?>
      <div class="post__img">
        <img src="<?php echo HOST . "usercontent/blog/{$post['cover']}";?>" alt="<?php echo $post['title'];?>" />
      </div>
      <?php endif; ?>

      <div class="post-meta">
        <div class="post-meta__readtime">
    
          <svg class="icon icon--calendar">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#calendar';?>"></use>
          </svg>

          <time datetime="2025-05-28"><?php echo h(rus_date("j F Y", $post['timestamp']));?></time>
          <div class="post-meta__text">Время на чтение</div>
        
        </div>
        <div class="post-meta__views">
          <svg class="icon icon--eye">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#eye';?>"></use>
          </svg>
          <span class="post-card__views-counter">22</span>
          <div class="post-meta__text">Просмотров</div>
        </div>
        <div class="post-meta__date">
    
          <svg class="icon icon--calendar">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#calendar';?>"></use>
          </svg>

          <time datetime="2025-05-28"><?php echo h(rus_date("j F Y", $post['timestamp']));?></time>
          <div class="post-meta__text">Опубликовано</div>
        </div>
      </div>
   
      <div class="section-posts__content">
        <?php echo $post['content'];?>
      </div>
    </div>
    <div class="page-post__post-pagination">
      <!-- <?php include ROOT . "templates/_parts/post-nav.tpl";?> -->
    </div>
  </section>

</main>