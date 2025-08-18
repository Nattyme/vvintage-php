<div class="filter-group">
  <h3 class="filter-title">Бренды</h3>
  <ul class="filter-list" data-show-count="5">
  <?php foreach($viewModel['brands'] as $brand) : ?>
    <li class="filter-list__item">
      <label class="filter-checkbox">
        <input 
          class="real-checkbox" 
          type="checkbox" 
          name="brand[]" 
          value="<?php echo $brand->getId();?>"
          <?php echo in_array( $brand->getId(), $_GET['brand'] ?? []) ? 'checked' : '';?>
        >
        <span class="custom-checkbox"></span>
        <div><?php echo $brand->getTranslatedTitle($viewModel['locale']);?></div>
      </label>
    </li>
  <?php endforeach;?>
  </ul>

  <div class="filter-group__button" id="filter-brand-btn">
    <button type="button" class="filter-show-more" data-target="brand" id="show-more-brands">Показать ещё</button>
  </div>
</div>

 