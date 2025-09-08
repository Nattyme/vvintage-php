<aside class="product-sidebar">
  <div class="filter">
      <?php
        include ROOT . 'views/shop/_sidebar/_filter/_price.tpl';
        include ROOT . 'views/shop/_sidebar/_filter/_categories.tpl';
        include ROOT . 'views/shop/_sidebar/_filter/_brands.tpl';
      ?>
    
      <div class="filter__buttons">
        <button type="submit" class="button button--primary button--s">Применить фильтры</button>
        <a href="<?php echo HOST . 'shop'; ?>" class="button button--outline button--s">Сбросить фильтры</a>
      </div>
  </div>
</aside>