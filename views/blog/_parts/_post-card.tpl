<?php

  // $params = ['rusDateFormat' => 'j F Y'];
  // include ROOT . 'views/blog/_parts/_post-display-details.tpl';
;?>

<article class="post-card">
  <div class="post-card__img-wrapper">
    <img src="<?php echo HOST . 'usercontent/blog/' . $post->cover_small;?>" alt="<?php echo $post->title;?>">
  </div>
  <div class="post-card__text">
    <div class="post-card__title">
      <h2 class="h2"><?php echo $post->title;?></h2>
    </div>
    <div class="post-card__meta">
      <ul class="post-meta">
        <li class="post-meta__date">
    
          <svg class="icon icon--calendar">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#calendar';?>"></use>
          </svg>
           <time datetime="<?php echo $post->iso_date ?>"><?php echo $post->formatted_date; ?></time> 
        </li>
        <li class="post-meta__views">
          <svg class="icon icon--eye">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#eye';?>"></use>
          </svg>
          <span class="post-card__views-counter">
            <?php echo $post->views;?>
          </span>
        </li>
      </ul>
   
    </div>
    <div class="post-card__description">
      <p><?php echo $post->description;?></p>
    </div>
  </div>

</article>