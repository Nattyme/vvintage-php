<div class="admin-page__content-form">
  <div class="admin-form">
    <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
    <?php include ROOT . "admin/templates/components/success.tpl"; ?>

    <header class="admin-form__header admin-form__row">
      <!-- SELECT -->
      <form method="GET" action="" class="form-products-table__actions">
        <select class="select" name="action">
          <option value="">— Все разделы —</option>
          <?php foreach ($mainCats as $mainCat) : ?>
              <option value="<?php echo h($mainCat['id']); ?>" <?php echo ($filterSection == $mainCat['id']) ? 'selected' : '' ?>>
                <?php echo h($mainCat['title']) ?>
              </option>
          <?php endforeach;?>
        </select>
        <button type="submit" class="button button--s button--primary">Применить</button>
      </form>
      <!-- // SELECT -->

      <!-- SEARCH FORM-->
      <form method="GET" action="" class="search" role="search">
        <input 
          type="text" 
          name="query" 
          placeholder="Найти" 
          value="<?php echo h($searchQuery);?>"
        >

        <button type="search-submit">
          <svg class="icon icon--loupe">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#loupe';?>"></use>
          </svg>
        </button>
      </form>
      <!-- SEARCH FORM-->
    </header>

    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Дата</th>
          <th>Имя и Фамилия</th>
          <th>Email</th>
          <th>Статус</th>
          <th>Оплата</th>
          <th>Стоимость</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($orders as $order) : ?>
          <?php include(ROOT . 'admin/templates/orders/parts/_order-in-list.tpl'); ?>
        <?php endforeach; ?> 
      </tbody>
    </table>
    <!-- Пагинация -->
    <div class="admin-form__item">
      <div class="section-pagination">
          <?php include ROOT . "admin/templates/_parts/pagination/_pagination.tpl"; ?>
      </div>
    </div>
    <!--// Пагинация -->
  </div>
</div>
