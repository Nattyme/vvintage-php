<?php
  $params = ['coverKey' => 'cover', 'rusDateFormat' => 'j F Y'];
  include ROOT . 'templates/blog/_parts/_post-display-details.tpl';
;?>

<article class="post-card">
  <div class="post-card__img-wrapper">
    <img src="<?php echo $coverPath . $coverFile;?>" alt="<?php echo $title;?>">
  </div>
  <div class="post-card__text">
    <div class="post-card__title">
      <h2 class="h2"><?php echo $title;?></h2>
    </div>
    <div class="post-card__meta">
      <ul class="post-meta">
        <li class="post-meta__date">
    
          <svg class="icon icon--calendar">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#calendar';?>"></use>
          </svg>
          <time datetime="<?php echo $dateTime;?>"><?php echo $rusDate;?></time>
        </li>
        <li class="post-meta__views">
          <svg class="icon icon--eye">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#eye';?>"></use>
          </svg>
          <span class="post-card__views-counter">
            <?php echo $views;?>
          </span>
        </li>
      </ul>
   
    </div>
    <div class="post-card__description">
      <p><?php echo $description;?></p>
    </div>
  </div>

</article>