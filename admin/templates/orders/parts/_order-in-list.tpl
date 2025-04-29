<tr <?php echo $order['status'] === 'new' ? 'class="message-new"' : NULL;?>>
  <td>
    <?php echo $order['id'];?>
  </td>
  <td>
    <?php if ($order['timestamp']) { echo rus_date('j F Y G:i', $order['timestamp']); } ?>
  </td>
  <td>
    <a class="link-to-page" href="<?php echo HOST . 'admin/order?id=' . $order['id'];?>">
      <?php echo $order['name'] . '&nbsp;' . $order['surname'];  ?>
    </a>
  </td>
  <td>
      <?php echo $order['email']; ?>
  </td>
  <td>
      <?php echo $order['status']; ?>
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
    <?php echo format_price($order['price']); ?> руб.
  </td>
  <td>
    <a href="<?php echo HOST . "admin/order-delete?id={$order['id']}" ;?>" class="icon-delete"></a>
  </td>
</tr>