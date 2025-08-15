 <div class="gallery gallery--<?php echo h($viewModel['imagesTotal']); ?>">

  <figure class="gallery__item gallery__item--1">
    <a 
      href="<?php echo HOST . 'usercontent/products/' . u($viewModel['main']->getFilename());?>" 
      data-thumb="<?php echo HOST . 'usercontent/products/' . h($viewModel['main']->getFilename());?>"
      data-fancybox="gallery">

      <picture>
        <img 
          class="product__img product__img--main"
          src="<?php echo HOST . 'usercontent/products/' . u($viewModel['main']->getFilename());?>" 
          srcset="<?php echo HOST . 'usercontent/products/' . u($viewModel['main']->getFilename());?>" alt="" loading="lazy"
        >
      </picture>
    </a>
  </figure>

  <?php foreach ($viewModel['gallery']['visible'] as $i => $image) : ?>
    <figure class="gallery__item gallery__item--<?php echo $i + 2; ?>">
      <a data-fancybox="gallery" href="<?php echo HOST . 'usercontent/products/' . u($image->getFilename());?>" 
          data-thumb="<?php echo HOST . 'usercontent/products/' . h($image->getFilename());?>">
        <picture>
          <img 
            class="product__img"
            src="<?php echo HOST . 'usercontent/products/' . u($image->getFilename());?>" 
            srcset="<?php echo HOST . 'usercontent/products/' . u($image->getFilename());?>" alt="" loading="lazy"
          >
        </picture>
      </a>
    </figure>
  <?php endforeach; ?>

  <?php foreach($viewModel['gallery']['visible'] as $image) : ?>
    <a 
      data-fancybox="gallery" href="<?php echo HOST . 'usercontent/products/' . u($image->getFilename());?>" 
      data-thumb="<?php echo HOST . 'usercontent/products/' . h($image->getFilename());?>">
    </a>
  <?php endforeach; ?>

  <div class="fav-button-wrapper">
    <a 
      href="<?php echo HOST . 'addtofav?id=' . u($viewModel['product']->getId());?>" 
      class="fav-button <?php echo isProductInFav($viewModel['product']->getId()) ? 'fav-button--active' : '';?>"
    >
        <svg class="icon icon--favorite">
          <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#favorite';?>"></use>
        </svg>

    </a>
  </div>
  
</div>