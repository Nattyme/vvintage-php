<div class="filter__group">
  <h3 class="filter__title">Бренды</h3>
  <ul class="filter__list" data-show-count="5">
    <?php foreach($viewModel['brands'] as $brand) : ?>
      <li class="filter__item">
        <label class="filter__checkbox">
          <input 
            class="filter__checkbox-input real-checkbox" 
            type="checkbox" 
            name="brand[]" 
            value="<?php echo $brand->getId();?>"
            <?php echo in_array( $brand->getId(), $_GET['brand'] ?? []) ? 'checked' : '';?>
          >
          <span class="filter__checkbox-custom custom-checkbox"></span>
          <span class="filter__checkbox-label"><?php echo $brand->getTranslatedTitle($viewModel['locale']);?></span>
        </label>
      </li>
    <?php endforeach;?>
  </ul>

  <div class="filter__show-more" id="filter-brand-btn">
    <button type="button" class="show-more" data-target="brand" id="show-more-brands">Показать ещё</button>
  </div>
</div>

 