 <div class="gallery gallery--<?php echo h($viewModel['imagesTotal']); ?>">

  <figure class="gallery__item gallery__item--1">
    <a 
      href="<?php echo HOST . 'usercontent/products/' . 'medium-' . u($viewModel['main']->filename);?>" 
      data-thumb="<?php echo HOST . 'usercontent/products/' . 'small-' . h($viewModel['main']->filename);?>"
      data-fancybox="gallery">

      <picture>
        <img 
          class="product__img product__img--main"
          src="<?php echo HOST . 'usercontent/products/' . u($viewModel['main']->filename);?>" 
          srcset="<?php echo HOST . 'usercontent/products/' . u($viewModel['main']->filename);?>" 
          alt="<?php echo h($viewModel['main']->alt) ?? h($product->title);?>" 
          loading="lazy"
        >
      </picture>
    </a>
  </figure>

  <?php foreach ($viewModel['gallery']['visible'] as $i => $image) : ?>
    <?php $isLast = $i === count($viewModel['gallery']['visible']) - 1; ?>
    <figure class="gallery__item gallery__item--<?php echo $i + 2; ?>">
      <a data-fancybox="gallery" href="<?php echo HOST . 'usercontent/products/' . 'medium-' . u($image->filename);?>" 
          data-thumb="<?php echo HOST . 'usercontent/products/' . 'small-' .  h($image->filename);?>">
        <picture>
          <img 
            class="product__img"
            src="<?php echo HOST . 'usercontent/products/' . u($image->filename);?>" 
            srcset="<?php echo HOST . 'usercontent/products/' . u($image->filename);?>" 
            alt="<?php echo h($image->alt) ?? h($product->title);?>" 
            loading="lazy"
          >
        </picture>

        <?php 
          $countedHidden = count($viewModel['gallery']['hidden']) ?? null;

          // Проверяем: есть ли скрытые и это ли последний показываемый элемент
          if ($countedHidden && $isLast ) : 
        ?>
          <span class="gallery__counter">
            <span>+ <?php echo h($countedHidden);?></span>
          </span>
         <?php endif;?>
      </a>

    </figure>


  <?php endforeach; ?>

  <?php foreach($viewModel['gallery']['hidden'] as $image) : ?>
    <a 
      data-fancybox="gallery" href="<?php echo HOST . 'usercontent/products/' . u($image->filename);?>" 
      data-thumb="<?php echo HOST . 'usercontent/products/' . 'small-' . h($image->filename);?>">
    </a>
  <?php endforeach; ?>

  <div class="fav-button-wrapper">
    <a 
      class="fav-button <?php echo isProductInFav($viewModel['product']->id) ? 'fav-button--active' : '';?>"
      href="
        <?php 
            if (isProductInFav($viewModel['product']->id)) {
              echo HOST . 'removefromfav?id=' . u($viewModel['product']->id);
            } else {
               echo HOST . 'addtofav?id=' . u($viewModel['product']->id);
            }
        ?>
      " 
    >
        <svg class="icon icon--favorite">
          <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#favorite';?>"></use>
        </svg>

    </a>
  </div>

</div>