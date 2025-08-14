<a href="<?php echo HOST . 'shop/' . u($product->getId());?>" class="card">
  
    
    <?php if (file_exists(ROOT . 'usercontent/products/' . $mainImage->getFilename())) : ?>
      <picture>
        <source
          srcset="<?php echo HOST . 'usercontent/products/' . $mainImage->getFilename();?>"
          type="image/webp"
        />
        <source
          srcset="<?php echo HOST . 'usercontent/products/' . $mainImage->getFilename();?>"
          type="image/jpeg"
      
          />
          <img 
            src="<?php echo HOST . 'usercontent/products/' . $mainImage->getFilename();?>" 
            srcset="<?php echo HOST . 'usercontent/products/' . $mainImage->getFilename();?>" alt="" loading="lazy"
          >
    
      </picture>
    <?php else : ?>
      <picture>
        <source
          srcset="<?php echo HOST . 'usercontent/products/' . 'no-photo.jpg';?>"
          type="image/webp"
        />
        <source
          srcset="<?php echo HOST . 'usercontent/products/' . 'no-photo.jpg';?>"
          type="image/jpeg"
      
          />
          <img 
            src="<?php echo HOST . 'usercontent/products/' . 'no-photo.jpg';?>" 
            srcset="<?php echo HOST . 'usercontent/products/' . 'no-photo.jpg';?>" alt="" loading="lazy"
          >
    
      </picture>
    <?php endif; ?>

    <div class="fav-button-wrapper">
      <div 
        href="<?php echo HOST . 'addtofav?id=' . u($product->getId());?>" 
        class="fav-button <?php echo isProductInFav($product->getId()) ? 'fav-button--active' : '';?>"
      >
          <svg class="icon icon--favorite">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#favorite';?>"></use>
          </svg>

      </div>
    </div>


    <div class="card__desc">
      <div class="card__title block__text">
        <h4 class="h4 block__desc">
          <?php echo $product->getTitle() !== null ? h($product->getTitle()) : 'Название продукта';?>
        </h4>
      </div>
      <div class="card__row flex-block">
        <div class="card__price">
          <span><?php echo $product->getPrice() !== null ? h($product->getPrice()) : '5000';?>&nbsp;&euro;</span>
        </div>
      </div>
    </div>
</a>
 

  
 