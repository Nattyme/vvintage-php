<div class="filter-group">
  <h3 class="filter-title">Категории</h3>
  
  <ul class="filter-group__list" data-control="tab" id="filter-category">
    <?php foreach($viewModel['categories'] as $category) : ?>
      <li class="filter-group__item accordion__item" data-section="<?php $category['id'];?>">
        <button type="button" class="filter-group__btn accordion__btn">
          <?php echo $category['title'];?>
        </button>

        <?php if(!empty($category['children'])) : ?>
        <ul class="filter-group__sub-list accordion__content">
          <?php foreach($category['children'] as $child) : ?>
            <li class="filter-group__sub-item">
              <label class="filter-checkbox">
                <input class="real-checkbox" type="checkbox" name="category[]" value="<?php echo $child['id'];?>">
                <span class="custom-checkbox"></span>
                <div><?php echo $child['title'];?></div>
              </label>
            </li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>
      </li>
    <?php endforeach;?>
  </ul>

</div>

  

