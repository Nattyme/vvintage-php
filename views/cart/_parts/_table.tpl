 <div class="cart">
  <div class="cart__head">
    <div class="cart__grid">
      <div class="cart__grid-block">
        <p class="cart__heading">
          <?php echo h(__('product-list.table.title', [], 'product-list'));?>
        </р>
      </div>
      <div class="cart__grid-block">
        <p class="cart__heading">
          <?php echo h(__('product-list.table.qty', [], 'product-list'));?>
        </p>
      </div>
      <div class="cart__grid-block">
        <p class="cart__heading">
          <?php echo h(__('product-list.table.price', [], 'product-list'));?>
        </p>
      </div>
  
    </div>
  </div>

  <div class="cart__body">
    <?php 
      foreach ($productViewModel['products'] as $product) :

        // Получаем главное изображения 
        $images = $productViewModel['imagesByProductId'][$product->getId()] ?? null;
        $mainImage = $images['main'] ?? null;

        include ROOT . 'views/cart/_parts/_product.tpl';
      endforeach; 
    ?>
  </div>
  <div class="cart__bottom">
    <div class="cart__summary-wrapper">
      <div class="cart__summary">
        <div class="cart__grid">
          <p class="cart__total-amount">
            <?php echo h(__('product-list.table.ttl', [], 'product-list'));?>: 
            <span class="text-bold"><?php echo count($productViewModel['products']);?></span>
          </p>
          <p class="cart__total">
            <?php echo h(__('product-list.table.ttl.price', [], 'product-list'));?>: 
            <span class="text-bold"><?php echo h($productViewModel['totalPrice']); ?>&nbsp;&euro;</span>
          </p>
        </div>
      </div>
    </div>

    <div class="cart__row cart__row--end">
      <a href="<?php echo HOST;?>neworder" class="button button--primary button--l">
        <?php echo h(__('button.cart.order', [], 'buttons'));?>
      </a>
    </div>

  </div>

</div>
      