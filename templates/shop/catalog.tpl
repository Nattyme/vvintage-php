<main class="inner-page inner-page--products">
  <section class="products">
    <div class="container">
      <div class="products__content">
        <header class="shop-header">
          <div class="shop-header__title">
            <h1 class="h1">Магазин</h1>
          </div>

          <div class="breadcrumbs">
            <a href="#!" class="breadcrumb ">Главная</a>
            <span>&#8212;</span>
            <a href="#!" class="breadcrumb breadcrumb--active">Магазин</a>
          </div>
        </header>

        <div class="products__pages-shown">
          <div class="pages-shown">
            <p>Показано: <span>9</span> из&#160;<span>12</span> товаров</p>
          </div>
        </div>

        <div class="products__cards-wrapper">
          <div class="products__cards-row">
            <?php foreach ($products as $product) : ?>
           <?php include ROOT . 'templates/shop/_parts/_card.tpl';?>
            <?php endforeach; ?> 
            
          </div>
        </div>
        <div class="products__pages-shown">
          <div class="pages-shown">
            <p>Показано: <span>9</span> из&#160;<span>12</span> товаров</p>
          </div>
        </div>
        <div class="products__pagination">
          <div class="section-pagination">
            <a href="#" class="arrow arrow-prev none">
              <svg class="icon icon--arrow-right dark">
                <use href="./img/svgsprite/sprite.symbol.svg#arrow-right"></use>
              </svg>
            </a>

            <div class="section-pagination__item active">
              <a href="#" class="pagination-button">1</a>
            </div>
            <div class="section-pagination__item">
              <a href="#" class="pagination-button">2</a>
            </div>

            <a href="#" class="arrow arrow-next">
              <svg class="icon icon--arrow-right dark">
                <use href="./img/svgsprite/sprite.symbol.svg#arrow-right"></use>
              </svg>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>