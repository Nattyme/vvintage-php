<div class="filter__group">
  <h3 class="filter__title">
    <?php echo h(__('shop.price', [], 'shop'));?>
  </h3>
  <div class="filter__price">
    <input type="number" name="priceMin" placeholder="<?php echo h(__('shop.price.from', [], 'shop'));?>" value="<?php echo h($_GET['priceMin'] ?? '');?>">
    <span class="dash">—</span>
    <input type="number" name="priceMax" placeholder="<?php echo h(__('shop.price.to', [], 'shop'));?>" <?php echo h($viewModel['filterDto']->priceMax ?? '');?>>
  </div>
</div>