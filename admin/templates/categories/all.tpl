<div class="admin-page__content-form">
  <div class="admin-form">
    <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
    <?php include ROOT . "admin/templates/components/success.tpl"; ?>


    <header class="admin-form__header admin-form__row">
      <a href="<?php echo HOST . 'admin/category-new';?>" class="button button-primary" data-btn="add">
        Новая категория
      </a>

      <!-- SEARCH FORM-->
      <form method="GET" action="" class="search" role="search">
        <label for="query" class="visually-hidden">Найти</label>
        <input 
          id="query"
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
    </header>
    <form method="GET" action="" class="form-products-table__actions">
      <select class="select" name="action">
        <option value="">— Все разделы —</option>
        <?php foreach ($mainCats as $mainCat) : ?>
          <option value="<?php echo h($mainCat['id']); ?>" <?php echo ($filterSection == $mainCat['id']) ? 'selected' : '' ?>>
            <?php echo h($mainCat['title']) ?>
          </option>
        <?php endforeach;?>
      </select>
      <button type="submit" class="button button-primary button--small">Применить</button>
    </form>

    <!-- Таблица -->
    <table class="table">
      <thead class="product-table__header">
        <tr class="">
          <th>ID</th>
          <th>Категория</th>
          <th>Главный раздел</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($cats as $cat) : ?>

          <tr class="admin-form-table__row">
            <td class="admin-form-table__unit">
                <?php echo h($cat['id']);?>
            </td>
            
            <td class="admin-form-table__unit">
              <a class="link-to-page" href="<?php echo HOST; ?>admin/category-edit?id=<?php echo u($cat['id']);?>">
                <?php echo $cat['child_title'] ? h($cat['child_title']) : 'Нет подкатегорий';?>
              </a>
            </td>

            <td class="admin-form-table__unit">
              <?php echo $cat['parent_title'] ? h($cat['parent_title']) : '';?>
            </td>
           
            <td class="admin-form-table__unit">
              <a href="<?php echo HOST . 'admin/category-delete?id=' . u($cat['id']);?>" class="icon-delete link-above-others">
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
</div>
