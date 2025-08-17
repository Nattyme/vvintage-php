<div class="filter-group">
  <h3 class="filter-title">Бренды</h3>
  <?php foreach($viewModel['brands'] as $brand) : ?>
    <label class="filter-checkbox">
      <input class="real-checkbox" type="checkbox" name="brand[]" value="<?php echo $brand->getId();?>">
      <span class="custom-checkbox"></span>
      <div><?php echo $brand->getTranslatedTitle($viewModel['locale']);?></div>
    </label>
  <?php endforeach;?>

  <div class="filter-group__button" id="filter-brand-btn">
    <button type="button" class="filter-show-more" data-target="brand">Показать ещё</button>
  </div>
</div>

 