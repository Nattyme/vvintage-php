<aside class="product-sidebar">
  <div class="filter">
      <?php
        include ROOT . 'views/shop/_sidebar/_filter/_price.tpl';
        include ROOT . 'views/shop/_sidebar/_filter/_categories.tpl';
        include ROOT . 'views/shop/_sidebar/_filter/_brands.tpl';
      ?>
    
      <div class="filter__buttons">
        <button type="submit" class="button button--primary button--s">
          <?php echo h(__('button.apply.filters', [], 'buttons'));?>
        </button>
        <a href="<?php echo HOST . 'shop'; ?>" class="button button--outline button--s">
           <?php echo h(__('button.clear.filters', [], 'buttons'));?>
        </a>
      </div>
  </div>
</aside>