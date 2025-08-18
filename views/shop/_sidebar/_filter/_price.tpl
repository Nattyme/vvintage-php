<div class="filter__group">
  <h3 class="filter__title">Цена</h3>
  <div class="filter__price">
    <input type="number" name="priceMin" placeholder="от" value="<?php echo h($_GET['priceMin'] ?? '');?>">
    <span class="dash">—</span>
    <input type="number" name="priceMax" placeholder="до" <?php echo h($viewModel['filterDto']->priceMax ?? '');?>>
  </div>
</div>