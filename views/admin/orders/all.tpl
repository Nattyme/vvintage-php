<div class="admin-page__content-form">
  <div class="admin-form">
    <?php include ROOT . "views/components/errors.tpl"; ?>
    <?php include ROOT . "views/components/success.tpl"; ?>

    <header class="admin-form__header admin-form__row">
      <!-- SELECT -->
      <form method="GET" action="" class="form-products-table__actions">
        <select class="select" name="action">
          <option value="">— Все разделы —</option>
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
          <?php dd($order);?>
          <?php include(ROOT . 'views/orders/parts/_order-in-list.tpl'); ?>
        <?php endforeach; ?> 
      </tbody>
    </table>
    <!-- Пагинация -->
    <div class="admin-form__item">
      <div class="section-pagination">
          <?php include ROOT . "views/_parts/pagination/_pagination.tpl"; ?>
      </div>
    </div>
    <!--// Пагинация -->
  </div>
</div>
