<main class="product-page">
  <section class="product">
    <div class="container">
      <header class="shop-header">
        <?php include ROOT . 'views/_parts/breadcrumbs/breadcrumbs.tpl'; ?>
      </header>
      <div class="product__content">

        <!-- Галерея изображений -->
        <div class="product__gallery-container">
          <?php include ROOT . 'views/shop/_parts/_proudct-gallery.tpl'; ?>
        </div>
        <!-- // Галерея изображений -->

        <div class="product-card">
          <header class="product-card__header">
     
            <div class="product-card__row">
              <h1 class="h1 product-card__title"><?php echo h($productViewModel['product']->getTitle());?></h1>
            </div>
            <div class="product-card__row">
              <p>New without tegs</p>
              <a href="#" class="product-card__brand"><?php echo h($productViewModel['product']->getBrandTitle());?></a>
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
              <dt><?php echo h(__('product.brand.title', [], 'product'));?></dt>
              <dd><a href=""><?php echo h($productViewModel['product']->getBrandTitle());?></a></dd>
            </div>
            <div class="product-card__item">
              <dt><?php echo h(__('product.item.condition', [], 'product'));?></dt>
              <dd>New without tags</dd>
            </div>
            <div class="product-card__item">
               <dt><?php echo h(__('product.item.update', [], 'product'));?></dt>
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
            
              <button type="button" class="button button--primary button--l" disabled>
                <?php echo h(__('button.item.incart', [], 'buttons',));?>
              </button>
            <?php  else : ?>
              <a href="<?php echo HOST . 'addtocart?id=' . u($productViewModel['product']->getId());?>" class="button button--primary button--xl">
                <?php echo h(__('button.cart.add', [], 'buttons'));?>: 
              </a>
            <?php endif;?>
          </div>   
          

        </div>

      </div>
    </div>
  </section>

  <?php /** include ROOT. 'views/shop/_parts/_related-products.tpl'; */?>

</main>