<tr>
  <td>
    <a class="link-to-page" href="<?php echo HOST . 'profile-order?id=' . $order->getId();?>">
        <?php if ( $order->getDateTime() ) echo rus_date("j F Y в G:i", $order->getDateTime()->getTimestamp());  ?>
    </a>
  </td>
  <td>
    <?php echo $order->getStatus();?>
  </td>
  <td>
    <?php
      if ($order->getPaid()) {
        echo "Оплачен";
      } else {
        echo "Не оплачен<br>";
        echo "<a class='secondary-button link-above-others' href=' " . HOST . 'orderselectpayment?id=' .  $order->getId() . " '>Оплатить</a>";
      }
    ?>
  </td>
  <td>
    <?php echo format_price($order->getPrice());?> руб.
  </td>
</tr>