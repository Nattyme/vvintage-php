<div class="admin-page__content-form">

  <?php include ROOT . "admin/templates/components/success.tpl"; ?>

  <header class="admin-form__header admin-form__row">
    <a href="<?php HOST . 'shop-new';?>" class="button button--m button--primary" data-btn="add">
      <span>Добавить товар</span>
    </a>
    <form method="GET" action="" class="shop__search search" role="search">
      <label for="query" class="visually-hidden">Найти</label>
      <input 
        id="query" 
        name="query" 
        type="text" 
        placeholder="Найти" 
        value="<?php echo h($searchQuery);?>"
      > 
      <button type="search-submit">
        <svg class="icon icon--loupe">
          <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#loupe';?>"></use>
        </svg>
      </button>
    </form>
  </header>

  
  <form class="form-products-table">
    <div class="admin-form__row">
      <select class="select" name="action">
        <option value="">— Выберите действие —</option>
        <option value="delete">Удалить</option>
        <option value="hide">Скрыть</option>
        <option value="show">Показать</option>
      </select>
      <button type="select-submit" class="button button--s button--primary">Применить</button>
    </div>

    <!-- table -->
    <table class="product-table table">
      <!-- head -->
      <thead class="product-table__header">
        <tr>
          <th></th>
          <th class="product-table__item product-table__item--title">Наименование</th>
          <th>Бренд</th>
          <th>Категория</th>
          <th>Цена</th>
          <th>Ссылка</th>
          <th>Обновлён</th>
          <th class="product-table__item product-table__item--checkbox">
            <label>
              <input class="table__checkbox-hidden real-checkbox" type="checkbox" name="product" data-check="all">
              <span class="table__checkbox-fake custom-checkbox"></span>
            </label>
          </th>
        </tr>
      </thead>
      <!-- head -->

      <!-- body -->
      <tbody class="product-table__body">
        
        <?php foreach ($products as $product) : ?>
          <tr>
            <td class="product-table__img">
            <?php if (file_exists(ROOT . 'usercontent/products/' . $product['cover'])) : ?>
              <img 
                src="<?php echo HOST . 'usercontent/products/' . h($product['cover']);?>" 
                srcset="<?php echo HOST . 'usercontent/products/' . h($product['cover']);?>" 
                alt="<?php echo h($product['title']);?>" loading="lazy"
              >
            <?php else : ?>
              <img 
                src="  <?php echo HOST . 'usercontent/products/' . '290-no-photo.jpg';?>" 
                srcset="  <?php echo HOST . 'usercontent/products/' . '290-no-photo.jpg';?>" alt="<?php echo h($product['title']);?>"
              >
            <?php endif; ?>
            </td>
            <td class="product-table__item product-table__item--title">
              <!-- link-to-page -->
              <a class="link-to-page" href="<?php echo HOST . "admin/"; ?>shop-edit?id=<?php echo u($product['id']); ?>">
                <?php echo htmlspecialchars($product['title'] ? h($product['title']) : ''); ?>
              </a>
            </td>
            <td>
              <?php echo h($product['brand']); ?>
            </td>
            <td>
              <?php echo h($product['category'] ?? '');?>
            </td>
            <td>
              <?php echo h($product['price'] ?? ''); ?>  &euro;
            </td>
            <td>
              <a class="link" href="<?php echo u($product['url']);?>">vinted.fr</a>
            </td>
            <td>
                <?php echo h(rus_date("j. m. Y", $product['timestamp'])); ?>
              <!-- <button class="button-dropdownMenu" data-btn="menu">
                <svg class="icon icon--menu">
                  <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#menu';?>"></use>
                </svg>
              </button>
              <ul class="dropdownMenu dropdownMenu--product-table" role="menu">
                <li class="dropdownMenu__item">
                  <a class="dropdownMenu__link" href="#!" role="menuitem">
                    <svg class="icon icon--edit">
                      <use href="./img/svgsprite/sprite.symbol.svg#edit"></use>
                    </svg>
                    <span class="dropdownMenu__text">Изменить</span>
                  </a>
                </li>
                <li class="dropdownMenu__item">
                  <a class="dropdownMenu__link" href="#!" role="menuitem">
                    <svg class="icon icon--invisible">
                      <use href="./img/svgsprite/sprite.symbol.svg#invisible"></use>
                    </svg>
                    <span class="dropdownMenu__text">Невидимый</span>
                  </a>
                </li>
                <li class="dropdownMenu__item">
                  <a class="dropdownMenu__link" href="#!" role="menuitem">
                    <svg class="icon icon--copy">
                      <use href="./img/svgsprite/sprite.symbol.svg#copy"></use>
                    </svg>
                    <span class="dropdownMenu__text">Копировать</span>
                  </a>
                </li>
                <li class="dropdownMenu__item">
                  <a class="dropdownMenu__link" href="#!" role="menuitem">
                    <svg class="icon icon--external_link">
                      <use href="./img/svgsprite/sprite.symbol.svg#external_link"></use>
                    </svg>
                    <span class="dropdownMenu__text">Предпросмотр</span>
                  </a>
                </li>
                <li class="dropdownMenu__item">
              
                  <a class="dropdownMenu__link" href="<?php echo HOST . "admin/";?>shop-delete?id=<?php echo $product['id'];?>" role="menuitem">
                    <svg class="icon icon--delete">
                      <use href="./img/svgsprite/sprite.symbol.svg#delete"></use>
                    </svg>
                    <span class="dropdownMenu__text">Удалить</span>
                  </a>
                </li>
              </ul> -->
            </td>
            <td class="product-table__item product-table__item--checkbox">
              <label>
                <input class="table__checkbox-hidden real-checkbox" type="checkbox" name="product" data-check="productId">
                <span class="table__checkbox-fake custom-checkbox"></span>
              </label>
            </td>
          </tr>
        <?php endforeach; ?> 
      </tbody>
      <!-- body -->
    </table>
    <!-- table -->

  </form>
  


  <div class="section-pagination">
    <?php if (count($products) > 0 ) : ?>
      <?php include ROOT . 'templates/_parts/pagination/_pagination.tpl';?>
    <?php endif; ?>
  </div>
  
</div>

