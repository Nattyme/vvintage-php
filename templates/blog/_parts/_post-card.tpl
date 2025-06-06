<article class="post-card">
  <div class="post-card__img-wrapper">
    <img src="<?php echo HOST . h("usercontent/blog/{$post['cover']}");?>" alt="">
  </div>
  <div class="post-card__text">
    <div class="post-card__title">
      <h2 class="h2"><?php echo h(shortText($post['title'], $limit = 200));?></h2>
    </div>
    <div class="post-card__meta">
      <div class="post-meta">
        <div class="post-meta__date">
    
          <svg class="icon icon--calendar">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#calendar';?>"></use>
          </svg>

          <time datetime="2025-05-28"><?php echo h(rus_date("j F Y", $post['timestamp']));?></time>
          <!-- <time datetime="2025-05-28"><?php echo h($post['timestamp']);?></time> -->
        </div>
        <div class="post-meta__views">
          <svg class="icon icon--eye">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#eye';?>"></use>
          </svg>
          <span class="post-card__views-counter">22</span>
        </div>
      </div>
   
    </div>
    <div class="post-card__description">
      <p><?php echo shortText($post['content'], $limit = 200);?></p>
    </div>
  </div>

</article>