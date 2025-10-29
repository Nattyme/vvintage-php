<main class="page-profile  inner-page">
  <section class="section">
    <div class="section__title">
      <div class="container">
        <h2 class="h2"><?php echo h(__('order.title', [], 'order'));?> &#8470;<?php echo $order->id;?></h2>
      </div>
    </div>

    <div class="section__body">
      <div class="container">
        <table class="order-table">
          <tr>
              <th><?php echo h(__('order.date_created', [], 'order'));?></th>
              <td>
                <?php echo h($order->formatted_date);?>
              </td>

          </tr>  
          <tr>
              <th><?php echo h(__('order.status', [], 'order'));?></th>
              <td>
                <?php echo h($order->status);?>
              </td>
          </tr>  
          <tr>
            <th><?php echo h(__('order.payment', [], 'order'));?></th>
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
            <th><?php echo h(__('order.total_cost', [], 'order'));?></th>
            <td>
              <?php echo h($order->price);?> &euro;.
            </td>
          </tr>   
          <tr>
            <th><?php echo h(__('order.full_name', [], 'order'));?></th>
            <td>
              <?php echo h($order->name) . ' ' . h($order->surname);?>
            </td>
          </tr>   
          <tr>
            <th><?php echo h(__('order.full_name', [], 'order'));?></th>
            <td>
              <?php echo h($order->email);?>
            </td>
          </tr>   
        </table>

        <table class="order-table">
          <tr>
            <th><?php echo h(__('order.photo', [], 'order'));?></th>
            <th><?php echo h(__('order.name', [], 'order'));?></th>
            <th><?php echo h(__('order.unit_price', [], 'order'));?></th>
            <th><?php echo h(__('order.quantity', [], 'order'));?></th>
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