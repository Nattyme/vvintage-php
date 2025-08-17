<div class="filter-group" data-control="tab">
  <h3 class="filter-title">Категории</h3>
  
  <!-- Навигация -->
  <div class="filter-group__tab-nav" data-control="tab-nav">
      <?php foreach($viewModel['mainCategories'] as $category) : ?>
        <button type="button" class="filter-group__tab-btn" data-control="tab-button">
          <?php echo $category->getTranslatedTitle($viewModel['locale']);?>
        </button>
      <?php endforeach;?>
    </div>
    <!--// Навигация -->

   <div class="filter-group__tab-content" data-control="tab-content">
      <?php foreach ($viewModel['mainCategories'] as $category ) : ?>
        <div class="filter-group__tab-block" data-control="tab-block">
          подкатегория
        </div>
      <?php endforeach;?>
    </div>
</div>

  

