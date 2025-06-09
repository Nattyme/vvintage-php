<article class="post-card-small">
  <div class="post-card-small__img-wrapper">
    <?php
      $coverPath = HOST . 'usercontent/blog/';
      $coverFile = isset($post['cover']) && file_exists(ROOT . 'usercontent/blog' . $post['cover'])
      ? h($post['cover'])
      : 'no-photo@2x.jpg';
    ?>
    <img src="<?php echo $coverPath . $coverFile;?>" alt="<?php echo h(shortText($post['title'], $limit = 80));?>">
  </div>
  <div class="post-card-small__text">
    <div class="post-card-small__title">
      <h2 class="h3 text-bold">
        <?php echo isset($post['title']) ? h(shortText($post['title'], $limit = 80)) : 'Статья блога "vvintage"';?>
      </h2>
    </div>
    
   
    <div class="post-card-small__description">
      <p><?php echo h(shortText($post['title'], $limit = 50)) ;?></p>
    </div>
     <div class="post-card-small__meta">
      <div class="post-meta">
        <div class="post-meta__date">
    
          <svg class="icon icon--calendar">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#calendar';?>"></use>
          </svg>
          <?php 
            $date = isset($post['timestamp']) ? $post['timestamp'] : time();
          ?>
          <time datetime="<?php echo h(date('Y-m-d', $date));?>">
            <?php echo h(rus_date("d.m.Y", $date));?>
          </time>
        </div>
        <div class="post-meta__views">
          <svg class="icon icon--eye">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#eye';?>"></use>
          </svg>
          <span class="post-card-small__views-counter"><?php echo isset($post['views']) ?  h($post['views']) : '0';?></span>
        </div>
      </div>
   
    </div>
  </div>

</article>