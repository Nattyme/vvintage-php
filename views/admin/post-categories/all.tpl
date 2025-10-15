<div class="admin-page__content-form">
  <div class="admin-form">
    <?php include ROOT . "views/components/errors.tpl"; ?>
    <?php include ROOT . "views/components/success.tpl"; ?>


    <header class="admin-form__header">
      <div class="admin-form__header-form admin-form__row">
        <a href="<?php echo HOST . 'admin/category-new';?>" class="button button--m button--outline" data-btn="add">
          Новый раздел
        </a>

        <!-- SEARCH FORM-->
        <form method="GET" action="" class="search" role="search">
          <label for="query" class="visually-hidden">Найти</label>
          <input 
            id="query"
            type="text" 
            name="query" 
            placeholder="Найти" 
            value="<?php echo h($searchQuery); ?>"
          >

          <button type="search-submit">
            <svg class="icon icon--loupe">
              <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#loupe';?>"></use>
            </svg>
          </button>
        </form>
        <!-- SEARCH FORM-->
      </div>
      <div class="admin-form__header-form admin-form__row">
        <form method="GET" action="" class="form-products-table__actions">
          <select class="select" name="action">
            <option value="">— Все разделы —</option>
        
            <?php foreach ($categories['main'] as $category) : ?>
              <option value="<?php echo h($category->id); ?>" <?php echo ($filterSection == $category->id) ? 'selected' : '' ?>>
                <?php echo h($category->title) ?>
              </option>
            <?php endforeach;?>
          </select>
          <button type="submit" class="button button--s button--primary">Применить</button>
        </form>
      </div>

    </header>


    <!-- Таблица -->
    <table class="table">
      <thead class="product-table__header">
        <tr class="">
          <th>ID</th>
          <th>Категория</th>
          <th>Раздел</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($categories['main'] as $category) : ?>

          <tr class="admin-form-table__row" data-id=" <?php echo h($category->id);?>" data-parent=" <?php echo h($category->parent_id);?>">
            <td class="admin-form-table__unit">
                <?php echo h($category->id);?>
            </td>
            
            <td class="admin-form-table__unit">
              <a class="link-to-page" href="<?php echo HOST; ?>admin/category-edit/<?php echo u($category->id);?>">
                <?php echo h($category->title);?>
              </a>
            </td>

            <td class="admin-form-table__unit"></td>
            <td>
              <a href="<?php echo HOST . 'admin/category-new/' . $category->id;?>" class="button button--s button--outline link-above-others" data-btn="add">
                Новая категория
              </a>
             
            </td>
            <td>
              <a 
                class="admin-form-table__unit button button-close cross-wrapper cart__delete link-above-others"   
                href="<?php echo HOST . 'admin/category-delete/' . u($category->id);?>"
                aria-label="Удалить категорию <?php echo h($category->title);?>"
              >

                  <span class="leftright"></span><span class="rightleft"> </span>
              </a>
            </td>
          </tr>
          
        <?php endforeach; ?> 

        <?php foreach ($categories['categories'] as $category) : ?>

          <tr class="admin-form-table__row" data-id=" <?php echo h($category->id);?>" data-parent=" <?php echo h($category->parent_id);?>">
            <td class="admin-form-table__unit">
                <?php echo h($category->id);?>
            </td>
            
            <td class="admin-form-table__unit">
             
            </td>

            <td class="admin-form-table__unit">
              <a class="link-to-page" href="<?php echo HOST; ?>admin/category-edit/<?php echo u($category->id);?>">
                <?php echo h($category->title);?>
              </a>
            </td>
            <td></td>
            <td>
              <a 
                class="admin-form-table__unit button button-close cross-wrapper cart__delete link-above-others"   
                href="<?php echo HOST . 'admin/category-delete/' . u($category->id);?>"
                aria-label="Удалить категорию <?php echo h($category->title);?>"
              >

                  <span class="leftright"></span><span class="rightleft"> </span>
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
      <?php include ROOT . "views/_parts/pagination/_pagination.tpl"; ?>
  </div>
  <!--// Пагинация -->
</div>
