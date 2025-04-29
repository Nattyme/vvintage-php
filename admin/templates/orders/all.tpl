<div class="admin-page__content-form">
  <div class="admin-form" style="max-width: unset; width: auto;">
    <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
    <?php include ROOT . "admin/templates/components/success.tpl"; ?>

    <div class="admin-form__item d-flex justify-content-between mb-20">
      <h2 class="heading">Заказы</h2>
    </div>

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
    <div class="admin-form__item pt-40">
      <div class="section-pagination">
          <?php include ROOT . "admin/templates/_parts/pagination/_pagination.tpl"; ?>
      </div>
    </div>
    <!--// Пагинация -->
  </div>
</div>
