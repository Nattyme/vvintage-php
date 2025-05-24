<div class="admin-page__content-form">
  <div class="admin-form">
    <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
    <?php include ROOT . "admin/templates/components/success.tpl"; ?>

    <header class="shop__header shop__row">
      <a href="<?php HOST;?>brand-new" class="shop__button button button-primary" data-btn="add">
        <span>Новый бренд</span>
      </a>
      <form method="GET" action="" class="shop__search search" role="search">
        <input type="text" name="query" placeholder="Найти">
        <button type="search-submit">
          <svg class="icon icon--loupe">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#loupe';?>"></use>
          </svg>
        </button>
      </form>
    </header>

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
                <?php echo $brand['id'];?>
            </td>
            
            <td>
            <a class="link-to-page" href="<?php echo HOST; ?>admin/brand-edit?id=<?php echo $brand['id'];?>">
                <?php echo $brand['title'];?>
              </a>
            </td>
           
            <td>
              <a href="<?php echo HOST . "admin/";?>brand-delete?id=<?php echo $brand['id'];?>" class="icon-delete link-above-others">
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
