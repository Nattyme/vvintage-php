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
              <div class="product-card__price"><span class="price"><?php echo $product['price'];?>&nbsp;&euro;</span></div>
            </div>
          </header>

          <dl class="product-card__list">
            <div class="product-card__item  product-card__item--title">
              <dt>Бренд</dt>
              <dd><a href=""><?php echo $product['brand_title'];?></a></dd>
            </div>
            <div class="product-card__item">
              <dt>Состоние</dt>
              <dd>New without tags</dd>
            </div>
            <div class="product-card__item">
              <dt>Обновлено</dt>
              <dd><time datetime="<?php echo $product['timestamp'];?>"><?php echo rus_date("j. m. Y", $product['timestamp']); ?></dd>
            </div>
          
          </dl>

          <div class="product-card__button">
            <?php if (array_key_exists($product['id'], $_SESSION['cart'])) : ?>
                <span class="button button-solid button-solid--success">Товар добавлен в корзину</span>
            <?php  else : ?>
                 <a href="<?php echo HOST . 'addtocart?id=' . $product['id'];?>" class="button button-solid">
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