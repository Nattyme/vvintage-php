<!-- Заказы пользователя -->
<section class="section bg-grey">
  <div class="container">

    <div class="section__title">
      <h2 class="heading">Мои заказы</h2>
    </div>

    <!-- products  -->
    <div class="section__body">
      <div class="row justify-content-center">
        <div class="col-md-10">

          <table class="table">
            <thead>
              <tr>
                <th>Дата</th>
                <th>Статус</th>
                <th>Оплата</th>
                <th>Стоимость</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                foreach ($orders as $order) {
                  include ROOT . 'templates/profile/_parts/_order-small.tpl';
                }
              ?>
            </tbody>
          </table>

        </div>
      </div>
    </div>
    <!--//  products -->

  </div>
</section>