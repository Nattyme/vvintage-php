<tr <?php echo $order->getStatus() === 'new' ? 'class="message-new"' : NULL;?>>
  <td>
    <?php echo h($order->getId());?>
  </td>
  <td>
    <?php echo h(rus_date('j. m. Y. H:i', $order->getDateTime()->getTimestamp()));?>
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
      <?php echo h($orderViewModel['statusData'][$order->getStatus()]); ?>
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
  </td>
  <td class="link-above-others">
    <label>
      <input 
        class="table__checkbox-hidden real-checkbox" 
        type="checkbox" 
        name="orders[]" 
        data-check="<?php echo h($order->getId());?>"
        value="<?php echo h($order->getId());?>"
      >
      <span class="table__checkbox-fake custom-checkbox"></span>
    </label>
  </td>
  <!-- <td>
    <a 
      class="admin-form-table__unit button button-close cross-wrapper cart__delete link-above-others"   
      href="<?php echo HOST . "admin/";?>order-delete/<?php echo u($order->getId());?>"
      aria-label="Удалить заказ от  <?php echo h($order->getName());?>"
    >

        <span class="leftright"></span><span class="rightleft"> </span>
    </a>
  </td> -->
</tr>