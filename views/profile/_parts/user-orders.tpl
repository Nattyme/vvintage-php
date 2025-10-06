<!-- Заказы пользователя -->
<section class="section bg-grey profile__order">
  <!-- <div class="container"> -->

    <div class="section__title">
      <h2 class="heading">
         <?php echo h(__('profile.my_orders', [], 'profile'));?>
      </h2>
    </div>

    <!-- products  -->
    <div class="section__body">
      <div class="row justify-content-center">
        <div class="col-md-10">

          <table class="table">
            <thead>
              <tr>
                <th>
                  <?php echo h(__('profile.orders.date', [], 'profile'));?>
                </th>
                <th>
                  <?php echo h(__('profile.orders.status', [], 'profile'));?>
                </th>
                <th>
                  <?php echo h(__('profile.orders.payment', [], 'profile'));?>
                </th>
                <th>
                  <?php echo h(__('profile.orders.total', [], 'profile'));?>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php 
                foreach ($orders as $order) {
                  include ROOT . 'views/profile/_parts/_order-small.tpl';
                }
              ?>
            </tbody>
          </table>

        </div>
      </div>
    </div>
    <!--//  products -->

  <!-- </div> -->
</section>