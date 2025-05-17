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
        <div class="product__desc">
          <header class="product__header">
            <div class="product-row">
              <h1 class="h3"><?php echo $product['title'];?></h1>
            </div>
            <div class="product-row">
              <p>New without tegs</p>
              <a href="#" class="product__brand"></a>
            </div>
            <div class="product-row">
              <div class="product__price"><span class="price"><?php echo $product['price'];?></span></div>
            </div>
          </header>

          <ul class="product-details">
            <li class="product-details__item">
              <p>Brand</p>
              <a href=""><?php echo $product['brand_title'];?></a>
            </li>
            <li class="product-details__item">
              <p>Condition</p>
              <p>New without tegs</p>
            </li>
            <li class="product-details__item">
              <p>Uploaded</p>
              <p>a&#160;day ago</p>
            </li>
          </ul>

          <div class="product__button">
            <a href="<?php echo HOST . 'addtocart?id=' . $product['id'];?>" class="button-solid" type="submit">Добавить в&#160;корзину</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include ROOT. 'templates/shop/_parts/_related-products.tpl';?>

</main>