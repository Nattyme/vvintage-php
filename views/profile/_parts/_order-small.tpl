<tr>
 
  <td>
    <a class="link-to-page" href="<?php echo HOST . 'profile/order/' . u($order->id);?>">
        <?php echo h($order->formatted_date);  ?>
    </a>
  </td>
  <td>
    <?php echo $order->status;?>
  </td>
  <td>
    <?php
      if ($order->paid) {
        echo "Оплачен";
      } else {
        echo "Не оплачен<br>";
        echo "<a class='secondary-button link-above-others' href=' " . HOST . 'orderselectpayment?id=' .  u($order->id) . " '>Оплатить</a>";
      }
    ?>
  </td>
  <td>
    <?php echo format_price($order->price);?> &euro;.
  </td>
</tr>