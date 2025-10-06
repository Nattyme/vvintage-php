
<div class="filter__group">
  <h3 class="filter__title">
    <?php echo h(__('shop.brands', [], 'shop'));?>
  </h3>
  <ul class="filter__list" data-show-count="5">
    <?php foreach($viewModel['brands'] as $brand) : ?>

      <li class="filter__item">
        <label class="filter__checkbox">
          <input 
            class="filter__checkbox-input real-checkbox" 
            type="checkbox" 
            name="brand[]" 
            value="<?php echo h($brand->id);?>"
            <?php echo in_array( $brand->id, $_GET['brand'] ?? []) ? 'checked' : '';?>
          >
          <span class="filter__checkbox-custom custom-checkbox"></span>

          <span class="filter__checkbox-label"><?php echo h($brand->translations[$currentLang]['title']);?></span>
        </label>
      </li>
    <?php endforeach;?>
  </ul>

  <div class="filter__show-more" id="filter-brand-btn">
    <button type="button" class="show-more" data-target="brand" id="show-more-brands">
      <?php echo h(__('shop.show.more', [], 'shop'));?>
    </button>
  </div>
</div>

 