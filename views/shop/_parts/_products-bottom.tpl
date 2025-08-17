<div class="products__bottom">
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

</div>
