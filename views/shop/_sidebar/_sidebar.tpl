<div class="product-sidebar">
  <div class="filter">
      <?php
        include ROOT . 'views/shop/_sidebar/_filter/_price.tpl';
        include ROOT . 'views/shop/_sidebar/_filter/_categories.tpl';
        include ROOT . 'views/shop/_sidebar/_filter/_brands.tpl';
      ?>
    
      <div class="filter__buttons">
        <button type="submit" class="button button--primary button--s"> Применить фильтры</button>
        <button type="submit" class="button button--outline button--s"> Сбросить фильтры</button>
      </div>
  </div>
</div>