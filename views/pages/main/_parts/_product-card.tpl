<div class="card">

  <div class="card__img">
    <svg class="icon icon--arrow-right">
      <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#arrow-right';?>"></use>
    </svg>

    <picture>
      <source
        srcset="<?php echo HOST . 'usercontent/products/' . h($product->image_filename);?>"
        type="image/webp"
      />
      <source
        srcset="<?php echo HOST . 'usercontent/products/' . h($product->image_filename);?>"
        type="image/jpeg"
    
        />
        <img 
          src="<?php echo HOST . 'usercontent/products/' . h($product->image_filename);?>" 
          srcset="<?php echo HOST . 'usercontent/products/' . h($product->image_filename);?>" alt="<?php echo $product->image_alt;?>" loading="lazy"
        >
   
    </picture>
  </div>

  <div class="card__desc">
    <a href="<?php echo HOST . 'shop/' . h($product->id);?>" class="card__title block__text link-abs">
      <h4 class="h4 block__desc"><?php echo h($product->title);?></h4>
    </a>

      <a  href="<?php echo HOST . 'shop?brand[]=' . h($product->brand_id);?>"class="card__brand">
        <span><?php echo $product->brand_title;?></span>
      </a> 
      <div class="card__price">
        <span><?php echo h($product->price);?>&nbsp;&euro;</span>
      </div>

    <!-- <a href="<?php echo HOST . 'shop/' . $product->id;?>" class="button button-primary">В корзину</a> -->
  </div>
</div>
 

  
 