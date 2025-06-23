<main class="product-page">
  <section class="product">
    <div class="container">
      <header class="shop-header">
        <?php include ROOT . 'views/_parts/breadcrumbs/breadcrumbs.tpl'; ?>
      </header>
      <div class="product__content">
          
        <div class="product__gallery-container">
          <?php
            $imagesTotal = $product->getImagesTotal();
            $images = $product->getImages();
            $related = $product->getRelated();
            $galleryVars = $product->getGalleryVars();
          ?>
          <div class="gallery gallery--<?php echo h($imagesTotal); ?>">
           
            <figure class="gallery__item gallery__item--1">
              <a 
                href="<?php echo HOST . 'usercontent/products/' . u($images['main']);?>" 
                data-thumb="<?php echo HOST . 'usercontent/products/' . h($images['main']);?>"
                data-fancybox="gallery">

                <picture>
                  <img 
                    class="product__img product__img--main"
                    src="<?php echo HOST . 'usercontent/products/' . u($images['main']);?>" 
                    srcset="<?php echo HOST . 'usercontent/products/' . u($images['main']);?>" alt="" loading="lazy"
                  >
                </picture>
              </a>
            </figure>
        
            <?php foreach ($galleryVars['visible'] as $i => $image) : ?>
              <figure class="gallery__item gallery__item--<?php echo $i + 2; ?>">
                <a data-fancybox="gallery" href="<?php echo HOST . 'usercontent/products/' . u($image);?>" 
                    data-thumb="<?php echo HOST . 'usercontent/products/' . h($image);?>">
                  <picture>
                    <img 
                      class="product__img"
                      src="<?php echo HOST . 'usercontent/products/' . u($image);?>" 
                      srcset="<?php echo HOST . 'usercontent/products/' . u($image);?>" alt="" loading="lazy"
                    >
                  </picture>
                </a>
              </figure>
            <?php endforeach; ?>

            <?php foreach($galleryVars['hidden'] as $image) : ?>
              <a 
                data-fancybox="gallery" href="<?php echo HOST . 'usercontent/products/' . u($image);?>" 
                data-thumb="<?php echo HOST . 'usercontent/products/' . h($image);?>">
              </a>
            <?php endforeach; ?>
           
          </div>
        </div>
        <div class="product-card">
          <header class="product-card__header">
     
            <div class="product-card__row">
              <h1 class="h1 product-card__title"><?php echo h($product->getTitle());?> </h1>
            </div>
            <div class="product-card__row">
              <p>New without tegs</p>
              <a href="#" class="product-card__brand"><?php echo h($product->getBrand());?></a>
            </div>
            <div class="product-card__row">
              <div class="product-card__price">
                <span class="price"><?php echo h($product->getPrice());?>&nbsp;&euro;
                </span>
              </div>
            </div>
          </header>

          <dl class="product-card__list">
            <div class="product-card__item  product-card__item--title">
              <dt>Бренд</dt>
              <dd><a href=""><?php echo h($product->getBrand());?></a></dd>
            </div>
            <div class="product-card__item">
              <dt>Состоние</dt>
              <dd>New without tags</dd>
            </div>
            <div class="product-card__item">
              <dt>Обновлено</dt>
              <dd>
                <time datetime="<?php echo h($product->getTimestamp());?>">
                <?php echo rus_date("j. m. Y", h($product->getTimestamp()) ); ?>
              </dd>
            </div>
          
          </dl>

          <div class="product__description">
            <?php echo $product->getContent();?>
          </div>

          <div class="product-card__button">
            <?php if (isset($_SESSION['cart']) && array_key_exists($product->getId(), $_SESSION['cart'])) : ?>
              <button type="button" class="button button--primary button--l" disabled>Товар в корзине</button>
            <?php  else : ?>
              <a href="<?php echo HOST . 'addtocart?id=' . u($product->getId());?>" class="button button--primary button--xl">
                Добавить&#160;в&#160;корзину
              </a>
            <?php endif;?>
          </div>   
          

        </div>

      </div>
    </div>
  </section>

  <?php include ROOT. 'view/shop/_parts/_related-products.tpl';?>

</main>