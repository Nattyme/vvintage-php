<!-- <a href="<?php echo HOST . 'shop/' . u($product->getId());?>" class="card">
  
    <div class="card__img">
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
    </div>


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
  -->

<div class="card">
  
  <div class="card__img">
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
          srcset="<?php echo HOST . 'usercontent/products/' . $mainImage->getFilename();?>"
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

  <div class="fav-button-wrapper">
    <a href="" 
      class="fav-button <?php echo isProductInFav($product->getId()) ? 'fav-button--active' : '';?>"
      data-id="<?php echo $product->getId();?>"
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

  <div class="card__desc">
    <a href="<?php echo HOST . 'shop/' . u($product->getId());?>" class="card__title link-to-page block__text">
      <h4 class="h4 block__desc">
        <?php echo $product->getTitle() !== null ? h($product->getTitle()) : 'Название продукта';?>
      </h4>
    </a>
    <div class="card__row flex-block">
      <div class="card__price">
        <span><?php echo $product->getPrice() !== null ? h($product->getPrice()) : '5000';?>&nbsp;&euro;</span>
      </div>
    </div>
  </div>
    </div>

 