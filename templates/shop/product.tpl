<main class="product-page">
  <section class="product">
    <div class="container">
      <header class="shop-header">
        <?php include ROOT . 'templates/_parts/breadcrumbs/breadcrumbs.tpl'; ?>
      </header>
      <div class="product__content">
          
        <div class="product__gallery-container">
          <div class="gallery gallery--<?php echo h($productImagesTotal); ?>">
           
            <figure class="gallery__item gallery__item--1">
              <a 
                href="<?php echo HOST . 'usercontent/products/' . u($mainImage);?>" 
                data-thumb="<?php echo HOST . 'usercontent/products/' . h($mainImage);?>"
                data-fancybox="gallery">

                <picture>
                  <img 
                    class="product__img product__img--main"
                    src="<?php echo HOST . 'usercontent/products/' . u($mainImage);?>" 
                    srcset="<?php echo HOST . 'usercontent/products/' . u($mainImage);?>" alt="" loading="lazy"
                  >
                </picture>
              </a>
            </figure>
        
            <?php foreach ($visibleImages as $i => $image) : ?>
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

            <?php foreach($hiddenImages as $image) : ?>
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
              <h1 class="h1 product-card__title"><?php echo h($product['title']);?> </h1>
            </div>
            <div class="product-card__row">
              <p>New without tegs</p>
              <a href="#" class="product-card__brand"><?php echo h($product['brand_title']);?></a>
            </div>
            <div class="product-card__row">
              <div class="product-card__price"><span class="price"><?php echo h($product['price']);?>&nbsp;&euro;</span></div>
            </div>
          </header>

          <dl class="product-card__list">
            <div class="product-card__item  product-card__item--title">
              <dt>Бренд</dt>
              <dd><a href=""><?php echo h($product['brand_title']);?></a></dd>
            </div>
            <div class="product-card__item">
              <dt>Состоние</dt>
              <dd>New without tags</dd>
            </div>
            <div class="product-card__item">
              <dt>Обновлено</dt>
              <dd><time datetime="<?php echo h($product['timestamp']);?>"><?php echo rus_date("j. m. Y", h($product['timestamp'])); ?></dd>
            </div>
          
          </dl>

          <div class="product__description">
            <?php echo $product['content'];?>
          </div>

          <div class="product-card__button">
            <?php if (isset($_SESSION['cart']) && array_key_exists($product['id'], $_SESSION['cart'])) : ?>
              <button type="button" class="button button--primary button--l" disabled>Товар в корзине</button>
            <?php  else : ?>
              <a href="<?php echo HOST . 'addtocart?id=' . u($product['id']);?>" class="button button--primary button--xl">
                Добавить&#160;в&#160;корзину
              </a>
            <?php endif;?>
          </div>   
          

        </div>

      </div>
    </div>
  </section>

  <?php include ROOT. 'templates/shop/_parts/_related-products.tpl';?>

</main>