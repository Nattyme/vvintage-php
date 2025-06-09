<article class="post-card">
  <div class="post-card__img-wrapper">
    <?php
      $coverPath = HOST . 'usercontent/blog/';
      $coverFile = isset($post['cover']) && file_exists(ROOT . 'usercontent/blog/' . $post['cover'])
      ? h($post['cover'])
      : 'no-photo@2x.jpg';
    ?>
    <img src="<?php echo $coverPath . $coverFile;?>" alt="">
  </div>
  <div class="post-card__text">
    <div class="post-card__title">
      <h2 class="h2"><?php echo h(shortText($post['title'], $limit = 200));?></h2>
    </div>
    <div class="post-card__meta">
      <ul class="post-meta">
        <li class="post-meta__date">
    
          <svg class="icon icon--calendar">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#calendar';?>"></use>
          </svg>

          <?php 
            $date = isset($post['timestamp']) ? $post['timestamp'] : time();
          ?>
          <time datetime="<?php echo h(date('Y-m-d', $date));?>"><?php echo h(rus_date("j F Y", $date));?></time>
          <!-- <time datetime="2025-05-28"><?php echo h($post['timestamp']);?></time> -->
        </li>
        <li class="post-meta__views">
          <svg class="icon icon--eye">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#eye';?>"></use>
          </svg>
          <span class="post-card__views-counter">22</span>
        </li>
      </ul>
   
    </div>
    <div class="post-card__description">
      <p><?php echo shortText($post['content'], $limit = 200);?></p>
    </div>
  </div>

</article>