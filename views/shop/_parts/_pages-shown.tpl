<div class="products__pages-shown">
  <div class="pages-shown">
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
