<tr>
  <td>
    <a class="link-to-page" href="<?php echo HOST . 'profile-order?id=' . $order['id'];?>">
        <?php if ($order['timestamp']) echo rus_date("j F Y в G:i", $order['timestamp']);  ?>
    </a>
  </td>
  <td>
    <?php echo $order['status'];?>
  </td>
  <td>
    <?php
      if ($order['paid']) {
        echo "Оплачен";
      } else {
        echo "Не оплачен<br>";
        echo "<a class='secondary-button link-above-others' href=' " . HOST . 'orderselectpayment?id=' . $order['id'] . " '>Оплатить</a>";
      }
    ?>
  </td>
  <td>
    <?php echo format_price($order['price']);?> руб.
  </td>
</tr>