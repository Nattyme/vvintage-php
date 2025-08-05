<tr <?php echo $order->getStatus() === 'new' ? 'class="message-new"' : NULL;?>>
  <td>
    <?php echo h($order->getId());?>
  </td>
  <td>
    <?php if ($order->getDatetime()) { echo rus_date('j F Y G:i', h($order->getDatetime())); } ?>
  </td>
  <td>
    <a class="link-to-page" href="<?php echo HOST . 'admin/order/' . u($order->getId());?>">
      <?php echo h($order->getName()) . '&nbsp;' . h($order->getSurname());  ?>
    </a>
  </td>
  <td>
      <?php echo h($order->getEmail()); ?>
  </td>
  <td>
      <?php echo h($order->getStatus()); ?>
  </td>
  <td>
    <?php 
      if ( $order->getPaid()) {
        echo 'Оплачен';
      } else {
        echo 'Не оплачен';
      }
    ?>
  </td>
  <td>
    <?php echo h(format_price($order->getPrice())); ?> руб.
  </td>
  <td>
    <a href="<?php echo HOST . 'admin/order-delete/' . u($order->getId());?>" class="icon-delete"></a>
  </td>
</tr>