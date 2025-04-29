<div class="admin-page__content-form">
  <div class="admin-form">
    <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
    <?php include ROOT . "admin/templates/components/success.tpl"; ?>

    <div class="admin-form__item admin-form__title">
      <h2 class="heading">Бренды</h2>
      <a class="button-solid button-solid--admin" href="<?php HOST;?>brand-new">Создать новый бренд</a>
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
        <?php foreach ($brands as $brand) : ?>

          <tr class="admin-form-table__row">
            <td class="admin-form-table__unit">
                <?php echo $brand['id'];?>
            </td>
            
            <td class="admin-form-table__unit">
            <a class="link-to-page" href="<?php echo HOST; ?>admin/brand-edit?id=<?php echo $brand['id'];?>">
                <?php echo $brand['title'];?>
              </a>
            </td>
           
            <td class="admin-form-table__unit">
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
