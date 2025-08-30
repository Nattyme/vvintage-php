<div class="admin-page__content-form">
  <div class="admin-form">
    <?php include (ROOT . "views/components/errors.tpl"); ?>
    <?php include (ROOT . "views/components/success.tpl"); ?>


    <header class="admin-form__header admin-form__row">
        <a href="<?php echo HOST . 'admin/category-blog-new';?>" class="button button--m button--outline" data-btn="add">
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
    </header>
    <form method="GET" action="" class="form-products-table__actions">
      <select class="select" name="action">
        <option value="">— Все разделы —</option>
        <?php foreach ($mainCats as $mainCat) : ?>
          <option value="<?php echo h($mainCat->getId()); ?>" <?php echo ($filterSection == $mainCat->getId()) ? 'selected' : '' ?>>
            <?php echo h($mainCat->getTitle()) ?>
          </option>
        <?php endforeach;?>
      </select>
      <button type="submit" class="button button--s button--primary">Применить</button>
    </form>

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
        <?php foreach ($cats as $cat) : ?>

          <tr class="admin-form-table__row">
            <td class="admin-form-table__unit">
                <?php echo h($cat->getId());?>
            </td>
            
            <td class="admin-form-table__unit">
              <a class="link-to-page" href="<?php echo HOST; ?>admin/category-blog-edit/<?php echo u($cat->getId());?>">
                <?php echo $cat->getParentId() === 0 ? h($cat->getTitle()) : '-';?>
              </a>
            </td>

            <td class="admin-form-table__unit">
              <?php echo $cat->getParentId() > 0 ? h($cat->getTitle()) : '';?>
            </td>
            <td>
              <?php 
                if ( $cat->getParentId() === 0 ) : ?>
                      <a href="<?php echo HOST . 'admin/category-blog-new/' . $cat->getId();?>" class="button button--s button--outline link-above-others" data-btn="add">
                        Новая категория
                      </a>
                <?php endif; ?>
            </td>
            <td>
              <a 
                class="admin-form-table__unit button button-close cross-wrapper cart__delete link-above-others"   
                href="<?php echo HOST . 'admin/category-blog-delete/' . u($cat->getId());?>"
                aria-label="Удалить категорию <?php echo h($cat->getTitle());?>"
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
