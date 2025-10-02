<div class="card">

  <div class="card__img">
    <?php if ( isset($product->images['main']) && (file_exists(ROOT . 'usercontent/products/' . $product->images['main']->filename) )) : ?>
      <picture>
        <source
          srcset="<?php echo HOST . 'usercontent/products/' . $product->images['main']->filename;?>"
          type="image/webp"
        />
        <source
          srcset="<?php echo HOST . 'usercontent/products/' . $product->images['main']->filename;?>"
          type="image/jpeg"
        />
        <img 
          src="<?php echo HOST . 'usercontent/products/' . $product->images['main']->filename;?>"
          srcset="<?php echo HOST . 'usercontent/products/' . $product->images['main']->filename;?>"
          alt=""
          loading="lazy"
        >
      </picture>
    <?php else : ?>
      <picture>
        <source
          srcset="<?php echo HOST . 'usercontent/products/no-photo.jpg';?>"
          type="image/webp"
        />
        <source
          srcset="<?php echo HOST . 'usercontent/products/no-photo.jpg';?>"
          type="image/jpeg"
        />
        <img 
          src="<?php echo HOST . 'usercontent/products/no-photo.jpg';?>"
          srcset="<?php echo HOST . 'usercontent/products/no-photo.jpg';?>"
          alt=""
          loading="lazy"
        >
      </picture>
    <?php endif; ?>
  </div>

  <?php if (isProductInFav($product->id)) : ?>
    <div class="fav-button-wrapper">
      <a href="" 
        class="fav-button <?php echo isProductInFav($product->id) ? 'fav-button--active' : '';?>"
        data-id="<?php echo $product->id;?>"
        aria-label="Добавить в избранное"
      >
        <svg class="icon icon--favorite" viewBox="0 0 20 20">
          <!-- нижний слой: белый толстый контур -->
          <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#favorite';?>" class="stroke-white"/>
          <!-- верхний слой: основной цвет -->
          <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#favorite';?>" class="stroke-main"/>
        </svg>
      </a>
    </div>
  <?php endif;?>

  <div class="card__desc">
    <a href="<?php echo HOST . 'shop/' . u($product->id);?>" class="card__title link-to-page block__text">
      <h4 class="h4 block__desc">
        <?php echo $product->title !== null ? h($product->title) : 'Название продукта';?>
      </h4>
    </a>
    <a href="<?php echo HOST . 'shop?brand[]=' . h($product->brand_id) ;?>" class="card__brand">
      <?php echo h($product->brand_title);?>
    </a>
    
    <div class="card__price">
      <span><?php echo $product->price !== null ? h($product->price) : '5000';?>&nbsp;&euro;</span>
    </div>
  
  </div>
</div>

 