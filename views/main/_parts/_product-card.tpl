<div class="card">

  <div class="card__img">
    <svg class="icon icon--arrow-right">
      <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#arrow-right';?>"></use>
    </svg>

    <picture>
      <source
        srcset="<?php echo HOST . 'usercontent/products/' . h($product->getMainImage());?>"
        type="image/webp"
      />
      <source
        srcset="<?php echo HOST . 'usercontent/products/' . h($product->getMainImage());?>"
        type="image/jpeg"
    
        />
        <img 
          src="<?php echo HOST . 'usercontent/products/' . h($product->getMainImage());?>" 
          srcset="<?php echo HOST . 'usercontent/products/' . h($product->getMainImage());?>" alt="" loading="lazy"
        >
   
    </picture>
  </div>

  <div class="card__desc">
    <a href="<?php echo HOST . 'shop/' . h($product->getId());?>" class="card__title block__text ink-abs">
      <h4 class="h4 block__desc"><?php echo h($product->getTitle());?></h4>
    </a>
    <div class="card__row flex-block">
      <div class="card__brand">
        <span><?php echo $product->getBrand();?></span>
      </div> 
      <div class="card__price">
        <span><?php echo h($product->getPrice());?>&nbsp;&euro;</span>
      </div>
    </div>
    <!-- <a href="<?php echo HOST . 'shop/' . $product->getId();?>" class="button button-primary">В корзину</a> -->
  </div>
</div>
 

  
 