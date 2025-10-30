<div class="admin-page__content-form">
  <div class="admin-form">

    <header class="admin-form__header admin-form__row">
      <!-- SEARCH FORM-->
      <form method="GET" action="" class="search" role="search">
        <input 
          type="text" 
          name="query" 
          placeholder="Найти" 
          value="<?php echo h($orderViewModel['searchQuery']);?>"
        >

        <button type="search-submit">
          <svg class="icon icon--loupe">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#loupe';?>"></use>
          </svg>
        </button>
      </form>
      <!-- SEARCH FORM-->
    </header>
    <form class="form-orders-table" method="POST">
      <!-- SELECT -->
      <div class="admin-form__row admin-form__header">
        <select class="select" name="action">
          <option value="">— Выберите действие —</option>
          <?php foreach ($orderViewModel['actions'] as $key => $value) : ?>
            <option value="<?php echo $key;?>"><?php echo $value;?></option>
          <?php endforeach;?>
        </select>
        <button name="action-submit" type="submit" class="button button--s button--primary" disabled>Применить</button>
      </div>
      <!-- SELECT -->

      <!-- table -->
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
            <th class="product-table__item product-table__item--checkbox">
              <label>
                <input 
                    class="table__checkbox-hidden real-checkbox" 
                    type="checkbox" name="orders[]" 
                    data-check-all
                >
                <span class="table__checkbox-fake custom-checkbox"></span>
              </label>
            </th>
          
          </tr>
        </thead>
        <tbody>
          <?php foreach ($orderViewModel['orders'] as $order) : ?>
        
            <?php include ROOT . 'views/admin/orders/parts/_order-in-list.tpl'; ?>
          <?php endforeach; ?> 
        </tbody>
      </table>
      <!-- table -->
    </form>
  </div>

  <!-- Пагинация -->
  <!-- <div class="admin-form__item">
      <div class="section-pagination">
          <?php include ROOT . "views/_parts/pagination/_pagination.tpl"; ?>
      </div>
  </div> -->
  <!--// Пагинация -->
</div>
