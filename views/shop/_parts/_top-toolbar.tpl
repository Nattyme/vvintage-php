
<div class="products__toolbar">
  <div class="products__results-info">
    <p>
      <?php 
        echo h(__('shop.shown.items', [
          '%count%' => $viewModel['shown'],
          '%total%' => $viewModel['total']
        ], 'shop'));
      ;?>
    </p>
  </div>

  <div class="products__sort">
    <?php include ROOT . 'views/shop/_sort/_by-price.tpl'; ?>
  </div>
</div>
