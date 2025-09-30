<div class="card">

  <div class="card__img">
    <svg class="icon icon--arrow-right">
      <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#arrow-right';?>"></use>
    </svg>

    <picture>
      <source
        srcset="<?php echo HOST . 'usercontent/products/' . h($product->images['main']->filename);?>"
        type="image/webp"
      />
      <source
        srcset="<?php echo HOST . 'usercontent/products/' . h($product->images['main']->filename);?>"
        type="image/jpeg"
    
        />
        <img 
          src="<?php echo HOST . 'usercontent/products/' . h($product->images['main']->filename);?>" 
          srcset="<?php echo HOST . 'usercontent/products/' . h($product->images['main']->filename);?>" alt="" loading="lazy"
        >
   
    </picture>
  </div>

  <div class="card__desc">
    <a href="<?php echo HOST . 'shop/' . h($product->id);?>" class="card__title block__text ink-abs">
      <h4 class="h4 block__desc"><?php echo h($product->title);?></h4>
    </a>
    <div class="card__row flex-block">
      <div class="card__brand">
        <span><?php echo $product->brand_title;?></span>
      </div> 
      <div class="card__price">
        <span><?php echo h($product->price);?>&nbsp;&euro;</span>
      </div>
    </div>
    <!-- <a href="<?php echo HOST . 'shop/' . $product->id;?>" class="button button-primary">В корзину</a> -->
  </div>
</div>
 

  
 