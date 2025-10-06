<main class="page-profile">
  <section class="section">
    <div class="section__title">
      <div class="container">
        <h2 class="h2">Заказ &#8470;<?php echo $order->getId();?></h2>
      </div>
    </div>

    <div class="section__body">
      <div class="container">
        <table class="order-table">
          <tr>
              <th>Дата создания</th>
              <td>
                <?php echo h(rus_date('j F Y в G:i', $order->getDateTime()->getTimestamp()));?>
              </td>

          </tr>  
          <tr>
              <th>Статус</th>
              <td>
                <?php echo $order->getStatus();?>
              </td>
          </tr>  
          <tr>
            <th>Оплата</th>
            <td>
              <?php 
                if ($order->getPaid()) {
                  // echo 'Оплачен' . rus_date('j F Y в G:i', $payment['timestamp']);
                } else {
                  echo 'Не оплачен<br>';
                  echo '<a href="' . HOST . 'orderselectpayment?id=' . $order->getId() .'" class="secondary-button">Оплатить</a>';
                }
                
              ?>
            </td>
          </tr>   
          <tr>
            <th>Общая стоимость</th>
            <td>
              <?php echo format_price($order->getPrice());?> руб.
            </td>
          </tr>   
          <tr>
            <th>Имя и Фамилия</th>
            <td>
              <?php echo $order->getName() . ' ' . $order->getSurname();?>
            </td>
          </tr>   
          <tr>
            <th>Email</th>
            <td>
              <?php echo $order->getEmail();?>
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
          <?php foreach($products as $product) : ?>

            <tr>
              <td>
                <img src="<?php echo HOST . 'usercontent/products/' . 'small-' . $product->images['main']->filename;?>" alt="<?php echo $product->title;?>">
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