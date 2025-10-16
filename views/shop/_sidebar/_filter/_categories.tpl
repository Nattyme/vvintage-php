<div class="filter__group">
  <h3 class="filter__title">
    <?php echo h(__('shop.categories', [], 'shop'));?>
  </h3>
 
  <ul class="filter__list" data-control="tab" id="filter-category">
    <?php foreach($viewModel['categories'] as $category) : ?>
      
      <li class="filter__item accordion__item <?php if (!empty($category->children)) echo ' filter__item--has-sublist'; ?>" data-section="<?php echo $category->id; ?>">
        <button type="button" class="filter__btn accordion__btn">
          <?php echo $category->title;?>
        </button>
        <?php if(!empty($category->children)) : ?>
        <ul class="filter__sub-list accordion__content">
          <?php foreach($category->children as $child) : ?>
            <li class="filter__sub-item">
              <label class="filter__checkbox">
                <input 
                  class="filter__checkbox-input real-checkbox" 
                  type="checkbox" 
                  name="category[]" 
                  value="<?php echo $child->id;?>"
                   <?php echo in_array($child->id, $viewModel['filterDto']->categories) ? 'checked' : ''; ?>>
                <span class="filter__checkbox-custom custom-checkbox"></span>
                <span class="filter__checkbox-label"><?php echo $child->title;?></span>
              </label>
            </li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>

      </li>
    <?php endforeach;?>
  </ul>

</div>

  

