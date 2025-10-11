<div class="card">
  <div class="card__img">
    <svg class="icon icon--arrow-right">
      <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#arrow-right';?>"></use>
    </svg>

    <picture>
      <source
        srcset="<?php echo HOST . 'usercontent/blog/' . $post->cover_small;?>"
        type="image/webp"
      />
      <source
        srcset="<?php echo HOST . 'usercontent/blog/' . $post->cover_small;?>"
        type="image/jpeg"
    
        />
        <img 
          src="<?php echo HOST . 'usercontent/products/' . $post->cover_small;?>" 
          srcset="<?php echo HOST . 'usercontent/products/' . $post->cover_small;?>" alt="" loading="lazy"
        >
   
    </picture>
  </div>

  <div class="card__desc">
    <a href="<?php echo HOST . 'shop/' . $post->id;?>" class="card__title block__text ink-abs">
      <h4 class="h4 block__desc"><?php echo $post->title;?></h4>
    </a>
  </div>
</div>
 

  
 