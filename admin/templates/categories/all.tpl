<div class="admin-page__content-form">
  <div class="admin-form">
    <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
    <?php include ROOT . "admin/templates/components/success.tpl"; ?>


    <header class="shop__header shop__row">
      <a href="<?php HOST;?>category-new" class="shop__button button button-primary" data-btn="add">
        <span>Новая категория</span>
      </a>

      <!-- SEARCH FORM-->
      <form method="GET" action="" class="shop__search search" role="search">
        <input 
          type="text" 
          name="query" 
          placeholder="Найти" 
          value="<?php htmlspecialchars($searchQuery);?>"
        >

        <button type="search-submit">
          <svg class="icon icon--loupe">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#loupe';?>"></use>
          </svg>
        </button>
      </form>
      <!-- SEARCH FORM-->
    </header>
    <div class="form-products-table__actions">
      <select class="select" name="action">
        <option value="">— Выберите раздел —</option>
        <?php foreach ($mainCats as $mainCat) : ?>
            <option value="<?= $mainCat['id'] ?>" <?= ($filterSection == $mainCat['id']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($mainCat['title']) ?>
            </option>
        <?php endforeach;?>
      </select>
      <button type="select-submit" class="button button-primary button--small">Применить</button>
    </div>

    <!-- Таблица -->
    <table class="admin-form-table table">
      <thead class="product-table__header">
        <tr class="">
          <th class="">ID</th>
          <th class="">Категория</th>
          <th class="">Главный раздел</th>
          <th class=""></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($cats as $cat) : ?>

          <tr class="admin-form-table__row">
            <td class="admin-form-table__unit">
                <?php echo $cat['id'];?>
            </td>
            
            <td class="admin-form-table__unit">
              <a class="link-to-page" href="<?php echo HOST; ?>admin/category-edit?id=<?php echo $cat['id'];?>">
                <?php echo $cat['child_title'];?>
              </a>
            </td>

            <td class="admin-form-table__unit">
              <?php echo $cat['parent_title'];?>
            </td>
           
            <td class="admin-form-table__unit">
              <a href="<?php echo HOST . "admin/";?>category-delete?id=<?php echo $cat['id'];?>" class="icon-delete link-above-others">
                <svg class="icon icon--delete">
                  <use href="https://womazing-php/static/img/svgsprite/sprite.symbol.svg#delete"></use>
                </svg> 
              </a>
            </td>
          </tr>
          
        <?php endforeach; ?> 
      </tbody>
    </table>
    <!--// Таблица -->

    <!-- Пагинация -->
    <div class="admin-form__item">
      <div class="section-pagination">
          <?php include ROOT . "admin/templates/_parts/pagination/_pagination.tpl"; ?>
      </div>
    </div>
    <!--// Пагинация -->
  </div>
</div>
