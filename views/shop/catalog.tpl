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

        <?php if (!empty($productViewModel['products']) ) : ?>
            <?php include ROOT . 'views/shop/_parts/_pages-shown.tpl';?>

            <div class="products__cards-wrapper">
              <div class="products__cards-row">
                <?php foreach ($productViewModel['products'] as $product) : ?>
                  <?php 
                      $images = $productViewModel['imagesByProductId'][$product->getId()] ?? null;
                      $mainImage = $images['main'] ?? null;
                  ?>
        
                  <?php include ROOT . 'views/shop/_parts/_card.tpl';?>
                <?php endforeach; ?>  
              </div>
            </div>

            <?php include ROOT . 'views/shop/_parts/_pages-shown.tpl';?>
       
        
            <div class="products__pagination">
              <div class="section-pagination">
                <?php include ROOT . 'views/_parts/pagination/_pagination.tpl';?>
              </div>
            </div>
        <?php else : ?>
            <div class="products__cards-wrapper">
              <h2> Здесь скоро будут редкие винтажные вещи и ароматы</h2>
            </div>
        <?php endif;?>

      </div>
    </div>
  </section>
</main>