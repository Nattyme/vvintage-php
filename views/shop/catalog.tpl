<main class="inner-page inner-page--products">
  <section class="products">

    <div class="container">
      <div class="products__content">
        <!-- Заголовок и хлебные крошки -->
        <header class="shop-header">
          <div class="shop-header__title">
            <h1 class="h1">Магазин</h1>
          </div>
          <?php include ROOT . 'views/_parts/breadcrumbs/breadcrumbs.tpl'; ?>

        </header>

        
        <!-- Форма фильтров и сортировки -->
        <form class="products__form" method="GET" action="<?php HOST . 'shop';?>">

          <!-- Панель управления сверху -->
           <?php include ROOT . 'views/shop/_parts/_top-toolbar.tpl';?>

          <!-- Сетка с фильтрами и карточками -->
          <div class="products__layout">
            
            <!-- Фильтры -->
            <?php include ROOT . 'views/shop/_sidebar/_sidebar.tpl';?>
         


            <!-- Карточки товаров -->
            <?php if (isset($viewModel['products']) && !empty($viewModel['products']) ): ?>
                <div class="products__cards">
                    <?php foreach ($viewModel['products'] as $product) : ?>
                      <?php include ROOT . 'views/shop/_parts/_card.tpl';?>
                    <?php endforeach; ?>  
                </div>
            <?php elseif(isset($_GET) && !empty($_GET)) : ?>
              <div class="products__empty products__empty--filtered">
                <h3>К сожалению, по вашему запросу ничего не найдено. Попробуйте изменить параметры фильтра.</h3>
              </div>
            <?php else : ?>
              <div class="products__empty products__empty--initial">
                <h3>В этой категории пока нет товаров. Мы работаем над пополнением!</h3>
              </div>
            <?php endif;?>
          </div>

          <!-- Панель внизу -->
          <div class="products__footer">
            <?php include ROOT . 'views/shop/_parts/_products-bottom.tpl';?>
          </div>

        </form>

        <?php if (isset($viewModel['products']) && !empty($viewModel['products']) ): ?>
          <div class="products__pagination">
            <div class="section-pagination">
              <?php include ROOT . 'views/_parts/pagination/_pagination.tpl';?>
            </div>
          </div>
        <?php endif; ?>
      </div>
          
    </div>

  </section>
</main>