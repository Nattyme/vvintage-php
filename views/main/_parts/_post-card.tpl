<div class="card">
  <div class="card__img">
    <svg class="icon icon--arrow-right">
      <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#arrow-right';?>"></use>
    </svg>

    <picture>
      <source
        srcset="<?php echo HOST . 'usercontent/blog/' . $post->getCoverSmall();?>"
        type="image/webp"
      />
      <source
        srcset="<?php echo HOST . 'usercontent/blog/' . $post->getCoverSmall();?>"
        type="image/jpeg"
    
        />
        <img 
          src="<?php echo HOST . 'usercontent/products/' . $post->getCoverSmall();?>" 
          srcset="<?php echo HOST . 'usercontent/products/' . $post->getCoverSmall();?>" alt="" loading="lazy"
        >
   
    </picture>
  </div>

  <div class="card__desc">
    <a href="<?php echo HOST . 'shop/' . $post->getId();?>" class="card__title block__text ink-abs">
      <h4 class="h4 block__desc"><?php echo $post->getTitle();?></h4>
    </a>
  </div>
</div>
 

  
 