<main class="inner-page inner-page--products">
  <section class="products">
    <div class="container">
      <div class="products__content">
        <header class="shop-header">
          <div class="shop-header__title">
            <h1 class="h1">Магазин</h1>
          </div>
          <?php include ROOT . 'views/_parts/breadcrumbs/breadcrumbs.tpl'; ?>
        </header>

        <?php if ($totalProducts > 0 ) : ?>
          <?php include ROOT . 'views/shop/_parts/_pages-shown.tpl';?>
        <?php endif; ?>

        <div class="products__cards-wrapper">
          <div class="products__cards-row">
            <?php foreach ($products as $product) : ?>
              <?php include ROOT . 'views/shop/_parts/_card.tpl';?>
            <?php endforeach; ?>  
          </div>
        </div>

        <?php if ($totalProducts > 0 ) : ?>
          <?php include ROOT . 'views/shop/_parts/_pages-shown.tpl';?>
        <?php endif; ?>
    
        
        <div class="products__pagination">
          <div class="section-pagination">
            <?php if ($totalProducts > 0 ) : ?>
              <?php include ROOT . 'views/_parts/pagination/_pagination.tpl';?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>