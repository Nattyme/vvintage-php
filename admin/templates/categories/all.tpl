<div class="admin-page__content-form">
  <div class="admin-form">
    <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
    <?php include ROOT . "admin/templates/components/success.tpl"; ?>

    <div class="admin-form__item admin-form__title">
      <h2 class="heading">Категории</h2>
      <a class="button button-solid button-solid--admin" href="<?php HOST;?>category-new">Создать новую категорию</a>
    </div>

    <!-- Таблица -->
    <table class="admin-form-table">
      <thead class="admin-form-table__header">
        <tr class="admin-form-table__row">
          <th class="admin-form-table__unit">ID</th>
          <th class="admin-form-table__unit">Название</th>
          <th class="admin-form-table__unit"></th>
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
                <?php echo $cat['title'];?>
              </a>
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
