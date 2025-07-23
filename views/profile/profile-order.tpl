<main class="page-profile">
  <section class="section">
    <div class="section__title">
      <div class="container">
        <h2 class="h2">Заказ &#8470;<?php echo $order['id'];?></h2>
      </div>
    </div>

    <div class="section__body">
      <div class="container">
        <table class="order-table">
          <tr>
              <th>Дата создания</th>
              <td>
                <?php if ($order['timestamp']) echo rus_date('j F Y в G:i', $order['timestamp']);?>
              </td>
          </tr>  
          <tr>
              <th>Статус</th>
              <td>
                <?php echo $order['status'];?>
              </td>
          </tr>  
          <tr>
            <th>Оплата</th>
            <td>
              <?php 
                if ($order['paid']) {
                  echo 'Оплачен' . rus_date('j F Y в G:i', $payment['timestamp']);
                } else {
                  echo 'Не оплачен<br>';
                  echo '<a href="' . HOST . 'orderselectpayment?id=' . $order['id'] .'" class="secondary-button">Оплатить</a>';
                }
                
              ?>
            </td>
          </tr>   
          <tr>
            <th>Общая стоимость</th>
            <td>
              <?php echo format_price($order['price']);?> руб.
            </td>
          </tr>   
          <tr>
            <th>Имя Фамилия</th>
            <td>
              <?php echo $order['name'] . ' ' . $order['surname'];?>
            </td>
          </tr>   
          <tr>
            <th>Email</th>
            <td>
              <?php echo $order['email'];?>
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
                <img src="<?php echo HOST . 'usercontent/products/' . $productsData[$product['id']]['filename_small'];?>" alt="<?php echo $product['title'] ;?>">
              </td>
              <td><?php echo $product['title'];?></td>

              <td>
                <?php echo format_price($product['price']);?> 
              </td>

              <td><?php echo $product['amount'];?></td>
            </tr>
          <?php endforeach; ?>
        </table>

        <a href="<?php echo HOST . 'profile';?>">Назад в профиль</a>
      </div>
    </div>
  </section>
</main>