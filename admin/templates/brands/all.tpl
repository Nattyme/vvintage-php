<div class="admin-page__content-form">
  <div class="admin-form">
    <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
    <?php include ROOT . "admin/templates/components/success.tpl"; ?>

    <header class="admin-form__header admin-form__row">
      <a href="<?php echo HOST . 'admin/brand-new';?>" class="shop__button button button-primary" data-btn="add">Новый бренд</a>

      <div class="search-block">
        <!-- SEARCH FORM-->
        <form method="GET" class="search" role="search">
          <input 
            type="text" 
            name="query" 
            placeholder="Найти" 
            value="<?php echo h($searchQuery);?>"
          >
          <button type="search-submit">
            <svg class="icon icon--loupe">
              <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#loupe';?>"></use>
            </svg>
          </button>   
        </form>

        <!-- SEARCH FORM-->
        <?php if (trim($searchQuery) !== '') : ?>
          <a href="<?php echo HOST;?>admin/brand" class="shop__button button button-primary">Сбросить</a>
        <?php endif;?>
      </div>

    </header>

    <?php if (!empty($brands)) : ?>
    <!-- Таблица -->
    <table class="admin-form-table table">
      <thead class="admin-form-table__header product-table__header">
        <tr>
          <th>ID</th>
          <th>Название</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($brands as $brand) : ?>

          <tr>
            <td >
                <?php echo h($brand['id']);?>
            </td>
            
            <td>
            <a class="link-to-page" href="<?php echo HOST; ?>admin/brand-edit?id=<?php echo u($brand['id']);?>">
                <?php echo h($brand['title']);?>
              </a>
            </td>
           
            <td>
              <a href="<?php echo HOST . "admin/";?>brand-delete?id=<?php echo u($brand['id']);?>" class="icon-delete link-above-others">
                <svg class="icon icon--delete">
                  <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#delete';?>"></use>
                </svg> 
              </a>
            </td>
          </tr>
          
        <?php endforeach; ?> 
      </tbody>
    </table>
    <!--// Таблица -->
  </div>
  <!-- Пагинация -->
  <div class="section-pagination">
      <?php include ROOT . "admin/templates/_parts/pagination/_pagination.tpl"; ?>
  </div>
  <!--// Пагинация -->

  <?php else : ?>
    Брендов по запросу не найдено
  <?php endif;?>
</div>
