<div class="filter-group">
  <h3 class="filter-title">Цена</h3>
  <div class="filter-price">
    <input type="number" name="price_min" placeholder="от" value="<?php echo h($_GET['priceMin'] ?? '');?>">
    <span class="dash">—</span>
    <input type="number" name="price_max" placeholder="до" <?php echo h($_GET['priceMax'] ?? '');?>>
  </div>
</div>