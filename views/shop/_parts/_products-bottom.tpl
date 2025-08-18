<div class="products__bottom">
  <div class="products__results-info">
    <p>
      <?php 
        if (isset($viewModel['products']) && !empty($viewModel['products']) ) : 
            echo h(__('shop.shown.items', [
              '%count%' => $viewModel['shown'],
              '%total%' => $viewModel['total']
            ], 'shop'));
        endif;
      ;?>
    </p>
  </div>

</div>
