<div class="filter-group">
  <h3 class="filter-title">Категории</h3>
  <?php foreach($viewModel['mainCategories'] as $category) : ?>
    <label class="filter-checkbox">
        <input class="real-checkbox" type="checkbox" name="category[]" value="<?php echo $category->getId();?>">
        <span class="custom-checkbox"></span>
        <div><?php echo $category->getTranslatedTitle($viewModel['locale']);?></div>
      </label>
  <?php endforeach;?>
  <button type="button" class="filter-show-more" data-target="category">Показать ещё</button>
</div>