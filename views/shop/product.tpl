<main class="product-page">
  <section class="product">
    <div class="container">
      <header class="shop-header">
        <?php include ROOT . 'views/_parts/breadcrumbs/breadcrumbs.tpl'; ?>
      </header>
      <div class="product__content">
          
        <div class="product__gallery-container">
          <div class="gallery gallery--<?php echo h($productViewModel['imagesTotal']); ?>">
           <!-- $productViewModel = [
            'product' => $product,
            'mainImage' => $imagesMainAndOthers['main'],
            'gallery' => $imageService->splitVisibleHidden($imagesMainAndOthers['others']),
            'related' => $relatedProducts,
        ]; -->
            <figure class="gallery__item gallery__item--1">
              <a 
                href="<?php echo HOST . 'usercontent/products/' . u($productViewModel['main']->getFilename());?>" 
                data-thumb="<?php echo HOST . 'usercontent/products/' . h($productViewModel['main']->getFilename());?>"
                data-fancybox="gallery">

                <picture>
                  <img 
                    class="product__img product__img--main"
                    src="<?php echo HOST . 'usercontent/products/' . u($productViewModel['main']->getFilename());?>" 
                    srcset="<?php echo HOST . 'usercontent/products/' . u($productViewModel['main']->getFilename());?>" alt="" loading="lazy"
                  >
                </picture>
              </a>
            </figure>
        
            <?php foreach ($productViewModel['gallery']['visible'] as $i => $image) : ?>
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

            <?php foreach($productViewModel['gallery']['visible'] as $image) : ?>
              <a 
                data-fancybox="gallery" href="<?php echo HOST . 'usercontent/products/' . u($image->getFilename());?>" 
                data-thumb="<?php echo HOST . 'usercontent/products/' . h($image->getFilename());?>">
              </a>
            <?php endforeach; ?>

            <div class="fav-button-wrapper">
              <a 
                href="<?php echo HOST . 'addtofav?id=' . u($productViewModel['product']->getId());?>" 
                class="fav-button <?php echo isProductInFav($productViewModel['product']->getId()) ? 'fav-button--active' : '';?>"
              >
                  <svg class="icon icon--favorite">
                    <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#favorite';?>"></use>
                  </svg>

              </a>
            </div>
           
          </div>
        </div>
        <div class="product-card">
          <header class="product-card__header">
     
            <div class="product-card__row">
              <h1 class="h1 product-card__title"><?php echo h($productViewModel['product']->getTitle());?> </h1>
            </div>
            <div class="product-card__row">
              <p>New without tegs</p>
              <a href="#" class="product-card__brand"><?php echo h($productViewModel['product']->getBrand());?></a>
            </div>
            <div class="product-card__row">
              <div class="product-card__price">
                <span class="price"><?php echo h($productViewModel['product']->getPrice());?>&nbsp;&euro;
                </span>
              </div>
            </div>
          </header>

          <dl class="product-card__list">
            <div class="product-card__item  product-card__item--title">
              <dt>Бренд</dt>
              <dd><a href=""><?php echo h($productViewModel['product']->getBrand());?></a></dd>
            </div>
            <div class="product-card__item">
              <dt>Состоние</dt>
              <dd>New without tags</dd>
            </div>
            <div class="product-card__item">
              <dt>Обновлено</dt>
              <dd>
                <time datetime="<?php /** echo h($product->getTimestamp()); */?>">
                <!-- <?php /** echo rus_date("j. m. Y", h($product->getTimestamp()) ); */ ?> -->
              </dd>
            </div>
          
          </dl>

          <div class="product__description">
            <?php echo $productViewModel['product']->getContent();?>
          </div>

          <div class="product-card__button">
            <?php if (isProductInCart($productViewModel['product']->getId())) : ?>
            
              <button type="button" class="button button--primary button--l" disabled>Товар в корзине</button>
            <?php  else : ?>
              <a href="<?php echo HOST . 'addtocart?id=' . u($productViewModel['product']->getId());?>" class="button button--primary button--xl">
                Добавить&#160;в&#160;корзину
              </a>
            <?php endif;?>
          </div>   
          

        </div>

      </div>
    </div>
  </section>

  <?php include ROOT. 'views/shop/_parts/_related-products.tpl';?>

</main>