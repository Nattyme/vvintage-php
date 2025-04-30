<section class="shop">
  <div class="shop__container">

    <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
    <?php include ROOT . "admin/templates/components/success.tpl"; ?>

    <header class="shop__header shop__row">
      <form method="GET" action="" class="shop__search search" role="search">
        <input type="text" name="query" placeholder="Найти">
        <button type="search-submit">
          <svg class="icon icon--loupe">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#loupe';?>"></use>
          </svg>
        </button>
      </form>
      <a href="<?php HOST;?>shop-new" class="shop__button button button-primary" data-btn="add">
        <span>Добавить товар</span>
       </a>

    </header>

    <div class="shop__content">
      <form>
        <div class="shop__bulk-actions">
          <select name="action">
            <option value="">— Выберите действие —</option>
            <option value="delete">Удалить</option>
            <option value="hide">Скрыть</option>
            <option value="show">Показать</option>
          </select>
          <button type="select-submit" class="button button--small">Применить</button>
        </div>
        <table class="product-table table">
          <thead class="product-table__header">
            <tr>
              <th>Фото</th>
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
          <tbody class="product-table__body">
            
            <?php foreach ($products as $product) : ?>
              <tr>
                <td class="product-table__img">
                <?php if (file_exists(ROOT . 'usercontent/products/' . $product['cover'])) : ?>
                  <img 
                    src="<?php echo HOST . 'usercontent/products/' . $product['cover'];?>" 
                    srcset="<?php echo HOST . 'usercontent/products/' . $product['cover'];?>" alt="" loading="lazy"
                  >
                <?php else : ?>
                  <img 
                    src="  <?php echo HOST . 'usercontent/products/' . '290-no-photo.jpg';?>" 
                    srcset="  <?php echo HOST . 'usercontent/products/' . '290-no-photo.jpg';?>" alt="Фото товара"
                  >
                <?php endif; ?>
                </td>
                <td class="product-table__item product-table__item--title">
                  <?php echo htmlspecialchars(trim($product['name'] ?? '')); ?>
                </td>
                <td>
                <!-- link-to-page -->
                  <a class="" href="<?php echo HOST . "admin/"; ?>shop-edit?id=<?php echo $product['id']; ?>"><?php echo $product['brand']; ?></a>
                </td>
                <td><?php echo htmlspecialchars(trim($product['category'] ?? ''));?></td>
                <td>
                  <?php echo htmlspecialchars(trim($product['price'] ?? '')); ?>  &euro;
                </td>
                <td>
                  <a class="link" href="https://www.vinted.fr/items/<?php echo $product['article'] . $product['url'];?>">vinted.fr</a>
                </td>
                <td>
                  <button class="button-dropdownMenu" data-btn="menu">
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
                  </ul>
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
        </table>
      </form>
    </div>

  </div>
</section>
