<div class="admin-page__content-form">
  <div class="admin-form">
    <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
    <?php include ROOT . "admin/templates/components/success.tpl"; ?>

   
    <header class="admin-form__header admin-form__row">
      <a href="<?php echo HOST . 'admin/category-blog-new';?>" class="button button--m button--primary" data-btn="add">
        Новая категория
      </a>
    </header>

    <!-- Таблица -->
    <table class="table">
      <thead class="product-table__header">
        <tr class="">
          <th class="">ID</th>
          <th class="">Категория</th>
          <th class=""></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($cats as $cat) : ?>

          <tr class="admin-form-table__row">
            <td class="admin-form-table__unit">
                <?php echo h($cat['id']);?>
            </td>
            
            <td class="admin-form-table__unit">
              <a class="link-to-page" href="<?php echo HOST; ?>admin/category-blog-edit?id=<?php echo u($cat['id']);?>">
                <?php echo h($cat['title']);?>
              </a>
            </td>
          
            <td class="admin-form-table__unit">
              <a href="<?php echo HOST . 'admin/category-blog-delete?id=' . u($cat['id']);?>" class="icon-delete link-above-others">
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
