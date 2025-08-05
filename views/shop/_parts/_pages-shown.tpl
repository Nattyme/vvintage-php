<div class="products__pages-shown">
  <div class="pages-shown">
    <p>
      <?php 
        echo h(__('shop.shown.items', [
          '%count%' => $productViewModel['shown'],
          '%total%' => $productViewModel['total']
        ], 'shop'));
      ;?>
    </p>
  </div>
</div>
