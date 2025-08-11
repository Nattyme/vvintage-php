<div class="admin-page__content-form">
  <div class="admin-form">
    <?php include ROOT . "views/components/success.tpl"; ?>
    <?php include ROOT . "views/components/errors.tpl"; ?>

    <header class="admin-form__header admin-form__row">
      <a href="<?php echo HOST . 'admin/brand-new';?>" class="shop__button button button-primary" data-btn="add">Новый бренд</a>

      <div class="search-block">
        <!-- SEARCH FORM-->
        <form method="GET" class="search" role="search">
          <!-- <input 
            type="text" 
            name="query" 
            placeholder="Найти" 
            value="<?php echo h($searchQuery);?>"
          > -->
          <button type="search-submit">
            <svg class="icon icon--loupe">
              <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#loupe';?>"></use>
            </svg>
          </button>   
        </form>

        <!-- SEARCH FORM-->
        <!-- <?php if (trim($searchQuery) !== '') : ?>
          <a href="<?php echo HOST;?>admin/brand" class="shop__button button button-primary">Сбросить</a>
        <?php endif;?> -->
      </div>

    </header>

    <?php if (!empty($brands)) : ?>
      
    <!-- Таблица -->
    <table class="admin-form-table table">
      <thead class="admin-form-table__header product-table__header">
        <tr>
          <th>ID</th>
          <th>Название</th>
          <th>Описание</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($brands as $brand) : ?>

          <tr>
            <td >
                <?php echo h($brand->getId());?>
            </td>
            
            <td>
              <a class="link-to-page" href="<?php echo HOST; ?>admin/brand-edit/<?php echo u($brand->getId());?>">
                <?php echo h($brand->getTranslatedTitle());?>
              </a>
            </td>
            <td>
              <a class="link-to-page" href="<?php echo HOST; ?>admin/brand-edit/<?php echo u($brand->getId());?>">
                <?php echo h($brand->getTranslatedDescription());?>
              </a>
            </td>
            <td>
              <a 
                class="admin-form-table__unit button button-close cross-wrapper cart__delete link-above-others"   
                href="<?php echo HOST . "admin/";?>admin/brand-delete/<?php echo u($brand->getId());?>"
                aria-label="Удалить категорию <?php echo h($brand->getTitle());?>"
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

  <?php else : ?>
    Брендов по запросу не найдено
  <?php endif;?>
</div>
