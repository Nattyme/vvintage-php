<div class="admin-page_content-form">
  <div class="admin-form">
    
    <?php include ROOT . 'views/components/errors.tpl'; ?>
    <?php include ROOT . 'views/components/success.tpl'; ?>

    <!-- table order info -->
    <div class="admin-form__field">
      <!-- SELECT -->
      <form method="GET" action="" class="form-products-table__actions">
          <select class="select" name="action">
            <option value="">— Выберите действие —</option>
            <?php foreach ($actions as $key => $value) : ?>
              <option value="<?php echo $key;?>" <?php $key === $statusData[$order->getStatus()] ? 'selected' : '';?> >
                <?php echo $value;?>
              </option>
            <?php endforeach;?>
          </select>
        <button disabled name="action-submit" type="submit" class="button button--s button--primary">Применить</button>
      </form>
      <!-- // SELECT -->

      <table class="table">

        <tr>
          <th>Дата создания</th>
          <td><?php if ($order->getDateTime()->getTimestamp()) echo rus_date("j F Y в G:i", h($order->getDateTime()->getTimestamp())) ;?></td>
        </tr>

        <tr>
          <th>Статус</th>
          <td><?php echo h($statusData[$order->getStatus()]);?></td>
        </tr>

        <tr>
          <th>Оплата</th>
          <td>
            <?php 
              if ( $order->getPaid()) {
                echo 'Оплачен';
              } else {
                echo 'Не оплачен';
              }
            ?>
          </td>
        </tr>

        <tr>
          <th>Общая стоимость</th>
          <td>
            <?php echo h(format_price($order->getPrice()));?> руб.
          </td>
        </tr>

        <tr>
          <th>Имя Фамилия</th>
          <td><?php echo h($order->getName()) . '' . h($order->getSurname());?></td>
        </tr>

        <tr>
          <th>Email</th>
          <td><?php echo h($order->getEmail());?></td>
        </tr>

      </table>

    </div>
    <!--// table order info-->

    <!-- table products  -->
    <div class="admin-form__field">
      <table class="table">
        <thead class="product-table__header">
          <tr>
            <th>Фотография</th>
            <th>ID</th>
            <th>Наименование</th>
            <th>Стоимость за единицу</th>
            <th>Количество</th>
          </tr>
        </thead>
        <?php foreach($order->getCart() as $product) : ?>
          <tr>
            <td>
              <!-- <img src="<?php echo HOST . 'usercontent/products/' . h($productsDB[$product['id']]['cover_small']);?>" alt="<?php echo h($product['title']) ;?>"> -->
            </td>
            <td><?php echo h($product['id']);?></td>
            <td><?php echo h($product['title']);?></td>

            <td>
              <?php echo h(format_price($product['price']));?> руб.
            </td>

            <td><?php echo h($product['amount']);?></td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
    <!--//  table products rows -->

    <!-- Buttons -->
    <div class="admin-form__field">
      <div class="buttons">
        <a class="button button--s button--outline" href="<?php echo HOST . 'admin/orders';?>">
          К списку заказов
        </a>
        <a href="<?php /* echo HOST . 'admin/order-delete?id=' . h($order->getId()); */?>" 
           class="button button--s button--primary button--warning">
          Удалить
        </a>
      </div>
    </div>
    <!-- // Buttons -->

  </div>
</div>