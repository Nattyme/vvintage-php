<?php
  $params = ['coverKey' => 'cover_small', 'rusDateFormat' => 'd.m.Y'];
  include ROOT . 'templates/blog/_parts/_post-display-details.tpl';
?>

<article class="post-card-small">
  <div class="post-card-small__img-wrapper">
    <img src="<?php echo $coverPath . $coverFile;?>" alt="<?php echo $title;?>">
  </div>
  <div class="post-card-small__text">
    <div class="post-card-small__title">
      <h2 class="h3 text-bold">
        <?php echo $title;?>
      </h2>
    </div>
    
   
    <div class="post-card-small__description">
      <p><?php echo $description;?></p>
    </div>
     <div class="post-card-small__meta">
      <div class="post-meta">
        <div class="post-meta__date">
    
          <svg class="icon icon--calendar">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#calendar';?>"></use>
          </svg>
          <time datetime="<?php echo $dateTime;?>">
            <?php echo $rusDate;?>
          </time>
        </div>
        <div class="post-meta__views">
          <svg class="icon icon--eye">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#eye';?>"></use>
          </svg>
          <span class="post-card-small__views-counter"><?php echo $views;?></span>
        </div>
      </div>
   
    </div>
  </div>

</article>