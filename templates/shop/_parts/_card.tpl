<div class="card">

  <a href="<?php echo HOST . 'shop/' . u($product['id']);?>" class="card__img link-abs">
    <svg class="icon icon--arrow-right">
      <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#arrow-right';?>"></use>
    </svg>

    <picture>
      <source
        srcset="<?php echo HOST . 'usercontent/products/' . h($product['filename']);?>"
        type="image/webp"
      />
      <source
        srcset="<?php echo HOST . 'usercontent/products/' . h($product['filename']);?>"
        type="image/jpeg"
    
        />
        <img 
          src="<?php echo HOST . 'usercontent/products/' . h($product['filename']);?>" 
          srcset="<?php echo HOST . 'usercontent/products/' . h($product['filename']);?>" alt="" loading="lazy"
        >
   
    </picture>
  </a>

  <div class="card__desc">
    <div class="card__title block__text">
      <h4 class="h4 block__desc"><?php echo h($product['title']);?></h4>
    </div>
    <div class="card__row flex-block">
      <div class="card__price">
        <span><?php echo h($product['price']);?>&nbsp;&euro;</span>
      </div>
    </div>
  </div>
</div>
 

  
 