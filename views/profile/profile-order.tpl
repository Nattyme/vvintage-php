<main class="page-profile">
  <section class="section">
    <div class="section__title">
      <div class="container">
        <h2 class="h2">Заказ &#8470;<?php echo $order->id;?></h2>
      </div>
    </div>

    <div class="section__body">
      <div class="container">
        <table class="order-table">
          <tr>
              <th>Дата создания</th>
              <td>
                <?php echo h($order->formatted_date);?>
              </td>

          </tr>  
          <tr>
              <th>Статус</th>
              <td>
                <?php echo h($order->status);?>
              </td>
          </tr>  
          <tr>
            <th>Оплата</th>
            <td>
              <?php 
                if ($order->paid) {
                  // echo 'Оплачен' . rus_date('j F Y в G:i', $payment['timestamp']);
                } else {
                  echo 'Не оплачен<br>';
                  echo '<a href="' . HOST . 'orderselectpayment?id=' . u($order->id) .'" class="secondary-button">Оплатить</a>';
                }
                
              ?>
            </td>
          </tr>   
          <tr>
            <th>Общая стоимость</th>
            <td>
              <?php echo h($order->price);?> &euro;.
            </td>
          </tr>   
          <tr>
            <th>Имя и Фамилия</th>
            <td>
              <?php echo h($order->name) . ' ' . h($order->surname);?>
            </td>
          </tr>   
          <tr>
            <th>Email</th>
            <td>
              <?php echo h($order->email);?>
            </td>
          </tr>   
        </table>

        <table class="order-table">
          <tr>
            <th>Фотография</th>
            <th>Наименование</th>
            <th>Стоимость за единицу</th>
            <th>Количество</th>
          </tr>
          <?php foreach($order->cart as $product) : ?>

            <tr>
              <td>
                <img src="<?php echo HOST . 'usercontent/products/' . 'small-' . $product->image;?>" alt="<?php echo $product->title;?>">
              </td>
              <td><?php echo $product->title;?></td>

              <td>
                <?php echo format_price($product->price);?> 
              </td>

              <td><?php echo $product->amount;?></td>
            </tr>
          <?php endforeach; ?>
        </table>

        <a href="<?php echo HOST . 'profile';?>">
          <?php echo h(__('profile.back', [], 'profile'));?>
        </a>
      </div>
    </div>
  </section>
</main>