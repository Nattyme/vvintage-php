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
        <form class="products__form" method="GET">

          <!-- Панель управления сверху -->
          <div class="products__toolbar">
            <div class="products__results-info">
              <p>Показано: <span>9</span> из <span>12</span> товаров</p>
            </div>

            <div class="products__sort">
              <label for="sort">Сортировать:</label>
              <select name="sort" id="sort" onchange="this.form.submit()">
                <option value="">По умолчанию</option>
                <option value="price_asc">Цена ↑</option>
                <option value="price_desc">Цена ↓</option>
              </select>
            </div>
          </div>

          <!-- Сетка с фильтрами и карточками -->
          <div class="products__layout">
            
            <!-- Фильтры -->
            <aside class="products__filters">

              <!-- Категории -->
              <div class="filter-group">
                <h3 class="filter-title">Категории</h3>
                <label class="filter-checkbox">
                  <input type="checkbox" name="category[]" value="phones">
                  <span>Телефоны</span>
                </label>
                <label class="filter-checkbox">
                  <input type="checkbox" name="category[]" value="laptops">
                  <span>Ноутбуки</span>
                </label>
                <label class="filter-checkbox hidden">
                  <input type="checkbox" name="category[]" value="accessories">
                  <span>Аксессуары</span>
                </label>
                <button type="button" class="filter-show-more" data-target="category">Показать ещё</button>
              </div>

              <!-- Бренды -->
              <div class="filter-group">
                <h3 class="filter-title">Бренды</h3>
                <label class="filter-checkbox">
                  <input type="checkbox" name="brand[]" value="apple">
                  <span>Apple</span>
                </label>
                <label class="filter-checkbox">
                  <input type="checkbox" name="brand[]" value="samsung">
                  <span>Samsung</span>
                </label>
                <label class="filter-checkbox hidden">
                  <input type="checkbox" name="brand[]" value="xiaomi">
                  <span>Xiaomi</span>
                </label>
                <button type="button" class="filter-show-more" data-target="brand">Показать ещё</button>
              </div>

              <!-- Цена -->
              <div class="filter-group">
                <h3 class="filter-title">Цена</h3>
                <div class="filter-price">
                  <input type="number" name="price_min" placeholder="от">
                  <span class="dash">—</span>
                  <input type="number" name="price_max" placeholder="до">
                </div>
              </div>

            </aside>


            <!-- Карточки товаров -->
            <div class="products__cards">
                <?php foreach ($productViewModel['products'] as $product) : ?>
                  <?php 
                      $images = $productViewModel['imagesByProductId'][$product->getId()] ?? null;
                      $mainImage = $images['main'] ?? null;
                  ?>
        
                  <?php include ROOT . 'views/shop/_parts/_card.tpl';?>
                <?php endforeach; ?>  
            </div>
          </div>

          <!-- Панель внизу -->
          <div class="products__footer">
            <div class="products__results-info">
              <p>Показано: <span>9</span> из <span>12</span> товаров</p>
            </div>
           
          </div>

        </form>


        <div class="products__pagination">
          <div class="section-pagination">
            <?php include ROOT . 'views/_parts/pagination/_pagination.tpl';?>
          </div>
        </div>
      </div>
          
    </div>

  </section>
</main>