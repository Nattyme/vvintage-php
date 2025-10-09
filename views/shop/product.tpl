<main class="product-page">
  <section class="product">
    <div class="container">
        
      <div class="product__content">
        <!-- Заголовок и хлебные крошки -->
        <?php include ROOT . 'views/_parts/_inner-header.tpl'; ?>
        
        <div class="product__data">

          <!-- Галерея изображений -->
          <div class="product__gallery-container">
            <?php include ROOT . 'views/shop/_parts/_product-gallery.tpl'; ?>
          </div>
          <!-- // Галерея изображений -->

          <div class="product-card">
            <header class="product-card__header">
      
              <div class="product-card__row">
                <h1 class="h1 product-card__title"><?php echo h($viewModel['product']->title);?></h1>
              </div>
            
              <div class="product-card__row">
                <a href="<?php echo HOST . 'shop?brand[]=' . h($viewModel['product']->brand_id) ;?>" class="product-card__brand">
                  <?php echo h($viewModel['product']->brand_title);?>
                </a>
              </div>
              <div class="product-card__row">
                <div class="product-card__price">
                  <span class="price"><?php echo formatPrice(h($viewModel['product']->price));?>;
                  </span>
                </div>
              </div>
            </header>

            <dl class="product-card__list">
              <div class="product-card__item  product-card__item--title">
                <dt><?php echo h(__('product.brand.title', [], 'product'));?></dt>
                <dd>
                  <a href="<?php echo HOST . 'shop?brand[]=' . h($viewModel['product']->brand_id) ;?>" class="product-card__brand">
                    <?php echo h($viewModel['product']->brand_title);?>
                  </a>
                </dd>
              </div>
              <!-- <div class="product-card__item"> -->
                <!-- <dt><?php echo h(__('product.item.condition', [], 'product'));?></dt> -->
                <!-- <dd>New without tags</dd> -->
              <!-- </div> -->
              <div class="product-card__item">
                <dt><?php echo h(__('product.item.update', [], 'product'));?></dt>
                <dd>
                  <time datetime="<?php echo rus_date("j. m. Y", h($viewModel['product']->edit_time)); ?>">
                  <?php echo rus_date("j. m. Y", h($viewModel['product']->edit_time) );  ?>
                </dd>
              </div>
            
            </dl>

            <div class="product__description">
              <?php echo $viewModel['product']->description;?>
            </div>

            <div class="product-card__button">
              <?php if (isProductInCart($viewModel['product']->id)) : ?>
              
                <button type="button" class="button button--primary button--l" disabled>
                  <?php echo h(__('button.item.incart', [], 'buttons'));?>
                </button>
              <?php  else : ?>
                <a href="<?php echo HOST . 'addtocart?id=' . u($viewModel['product']->id);?>" class="button button--primary button--xl">
                  <?php echo h(__('button.cart.add', [], 'buttons'));?>
                </a>
              <?php endif;?>
            </div>   
            

          </div>
          
        </div>

      </div>
    </div>
  </section>

  <?php /** include ROOT. 'views/shop/_parts/_related-products.tpl'; */?>

</main>