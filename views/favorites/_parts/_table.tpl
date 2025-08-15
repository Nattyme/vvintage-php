 <div class="cart">
  <div class="cart__head">
    <div class="cart__grid">
      <div class="cart__grid-block">
        <h2 class="cart__heading"><?php echo h(__('product-list.table.title', [], 'product-list'));?></р>
      </div>
      <div class="cart__grid-block">
        <p class="cart__heading">
           <?php echo h(__('product-list.table.price', [], 'product-list'));?>
        </p>
      </div>
  
    </div>
  </div>

  <div class="cart__body">
    <?php foreach ($viewModel['products'] as $product) :

        // Получаем главное изображения 
        $images = $viewModel['imagesByProductId'][$product->getId()] ?? null;
        $mainImage = $images['main'] ?? null;

        include ROOT . 'views/favorites/_parts/_product.tpl';
      endforeach;
    ?>
  </div>

  <div class="cart__bottom">
    <div class="cart__summary-wrapper">
      <div class="cart__summary">
        <div class="cart__grid">
          <p class="cart__total-amount">
             <?php echo h(__('product-list.table.ttl', [], 'product-list'));?>: 
             <span class="text-bold"><?php echo count($viewModel['products']);?></span>
          </p>
  
        </div>
      </div>
    </div>

  </div>

</div>