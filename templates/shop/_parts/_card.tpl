<div class="card">

  <a href="<?php echo HOST . 'shop/' . u($product['id']);?>" class="card__img link-abs">
    <?php if (file_exists(ROOT . 'usercontent/products/' . $product['filename'])) : ?>
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
  </a>

  <div class="card__desc">
    <div class="card__title block__text">
      <h4 class="h4 block__desc"><?php echo isset($product['title']) ? h($product['title']) : 'Название продукта';?></h4>
    </div>
    <div class="card__row flex-block">
      <div class="card__price">
        <span><?php echo isset($product['price']) ? h($product['price']) : '5000';?>&nbsp;&euro;</span>
      </div>
    </div>
  </div>
</div>
 

  
 