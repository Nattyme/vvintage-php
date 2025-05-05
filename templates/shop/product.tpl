<main class="product-page">
  <section class="product">
    <div class="container">
      <header class="shop-header">
        <div class="breadcrumbs">
          <a href="<?php echo HOST . '';?>" class="breadcrumb ">Главная</a>
          <span>&#8212;</span>
          <a href="<?php echo HOST . 'shop';?>" class="breadcrumb">Все товары</a>
          <span>&#8212;</span>
          <a href="#!" class="breadcrumb"><?php echo $product['cat_title'];?></a>
          <span>&#8212;</span>
          <a href="#!" class="breadcrumb breadcrumb--active"><?php echo $product['title'];?></a>
        </div>
      </header>
      <div class="product__content">
        <div class="product__gallery-container">
          <div class="product__gallery">
            <div class="product__gallery-block product__gallery-block--main-img">
              <figure class="product__img product__img--main">
                <a data-fancybox="gallery" href="<?php echo HOST . 'usercontent/products/' . $mainImage;?>" data-thumb="<?php echo HOST . 'usercontent/products/' . $mainImage;?>">
                  <picture>
                    <img 
                      src="<?php echo HOST . 'usercontent/products/' . $mainImage;?>" 
                      srcset="<?php echo HOST . 'usercontent/products/' . $mainImage;?>" alt="" loading="lazy"
                    >
                  </picture>
                </a>
              </figure>
            </div>
            <div class="product__gallery-block product__gallery-block--small-imgs">
              <?php foreach ($visibleImages as $image) : ?>
                <figure class="product__img product__img--main">
                  <a data-fancybox="gallery" href="<?php echo HOST . 'usercontent/products/' . $image;?>" data-thumb="<?php echo HOST . 'usercontent/products/' . $image;?>">
                    <picture>
                      <img 
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
        </div>
        <div class="product__desc">
          <header class="product__header">
            <div class="product-row">
              <h1 class="h1"><?php echo $product['title'];?></h1>
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
            <button class="button-solid" type="submit">Добавить в&#160;корзину</button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include ROOT. 'templates/shop/_parts/_related-products.tpl';?>

</main>