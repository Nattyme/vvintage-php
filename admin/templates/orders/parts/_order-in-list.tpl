<tr <?php echo $order['status'] === 'new' ? 'class="message-new"' : NULL;?>>
  <td>
    <?php echo h($order['id']);?>
  </td>
  <td>
    <?php if ($order['timestamp']) { echo rus_date('j F Y G:i', h($order['timestamp'])); } ?>
  </td>
  <td>
    <a class="link-to-page" href="<?php echo HOST . 'admin/order?id=' . u($order['id']);?>">
      <?php echo h($order['name']) . '&nbsp;' . h($order['surname']);  ?>
    </a>
  </td>
  <td>
      <?php echo h($order['email']); ?>
  </td>
  <td>
      <?php echo h($order['status']); ?>
  </td>
  <td>
    <?php 
      if ( $order['paid']) {
        echo 'Оплачен';
      } else {
        echo 'Не оплачен';
      }
    ?>
  </td>
  <td>
    <?php echo h(format_price($order['price'])); ?> руб.
  </td>
  <td>
    <a href="<?php echo HOST . 'admin/order-delete?id=' . u($order['id']);?>" class="icon-delete"></a>
  </td>
</tr>