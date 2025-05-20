<main class="product-page">
  <section class="product">
    <div class="container">
      <header class="shop-header">
        <?php include ROOT . 'templates/_parts/breadcrumbs/breadcrumbs.tpl'; ?>
      </header>
      <div class="product__content">
        <div class="product__gallery-container">
          <div class="gallery gallery--<?php echo $productImagesTotal; ?>">
           
              <figure class="gallery__item gallery__item--1">
                <a data-fancybox="gallery" href="<?php echo HOST . 'usercontent/products/' . $mainImage;?>" data-thumb="<?php echo HOST . 'usercontent/products/' . $mainImage;?>">
                  <picture>
                    <img 
                      class="product__img product__img--main"
                      src="<?php echo HOST . 'usercontent/products/' . $mainImage;?>" 
                      srcset="<?php echo HOST . 'usercontent/products/' . $mainImage;?>" alt="" loading="lazy"
                    >
                  </picture>
                </a>
              </figure>
          
              <?php foreach ($visibleImages as $i => $image) : ?>
                <figure class="gallery__item gallery__item--<?php echo $i + 2; ?>">
                  <a data-fancybox="gallery" href="<?php echo HOST . 'usercontent/products/' . $image;?>" data-thumb="<?php echo HOST . 'usercontent/products/' . $image;?>">
                    <picture>
                      <img 
                        class="product__img"
                        src="<?php echo HOST . 'usercontent/products/' . $image;?>" 
                        srcset="<?php echo HOST . 'usercontent/products/' . $image;?>" alt="" loading="lazy"
                      >
                    </picture>
                  </a>
                </figure>
              <?php endforeach; ?>

              <?php foreach($hiddenImages as $image) : ?>
                <a data-fancybox="gallery" href="<?php echo HOST . 'usercontent/products/' . $image;?>" data-thumb="<?php echo HOST . 'usercontent/products/' . $image;?>">
                </a>
              <?php endforeach; ?>
           
          </div>
        </div>
        <div class="product-card">
          <header class="product-card__header">
            <div class="product-card__row">
              <h1 class="h1 product-card__title"><?php echo $product['title'];?> </h1>
            </div>
            <div class="product-card__row">
              <p>New without tegs</p>
              <a href="#" class="product-card__brand"><?php echo $product['brand_title'];?></a>
            </div>
            <div class="product-card__row">
              <div class="product-card__price"><span class="price"><?php echo $product['price'];?></span></div>
            </div>
          </header>

          <dl class="product-card__list">
            <div class="product-card__item  product-card__item--title">
              <dt>Brand</dt>
              <dd><a href=""><?php echo $product['brand_title'];?></a></dd>
            </div>
            <div class="product-card__item">
              <dt>Condition</dt>
              <dd>New without tags</dd>
            </div>
            <div class="product-card__item">
              <dt>Uploaded</dt>
              <dd><time datetime="2025-05-18">a day ago</time></dd>
            </div>
          
          </dl>

          <div class="product-card__button">
            <a href="<?php echo HOST . 'addtocart?id=' . $product['id'];?>" class="button-solid">Добавить&#160;в&#160;корзину</a>
          </div>   
          

        </div>

      </div>
    </div>
  </section>

  <?php include ROOT. 'templates/shop/_parts/_related-products.tpl';?>

</main>