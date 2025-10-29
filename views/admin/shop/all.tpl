<div class="admin-page__content-form">

  <?php include ROOT . "views/components/success.tpl"; ?>

  <header class="admin-form__header admin-form__row">
    <a href="<?php echo HOST . 'admin/shop-new';?>" class="button button--m button--primary" data-btn="add">
      <span>Добавить товар</span>
    </a>
    <form method="GET" action="" class="shop__search search" role="search">
      <label for="query" class="visually-hidden">Найти</label>
      <input 
        id="query" 
        name="query" 
        type="text" 
        placeholder="Найти" 
        value="<?php /** echo h($searchQuery); */?>"
      > 
      <button type="search-submit">
        <svg class="icon icon--loupe">
          <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#loupe';?>"></use>
        </svg>
      </button>
    </form>
  </header>

  <form class="form-products-table" method="POST">
    <div class="admin-form__row admin-form__header">
      <select class="select" name="action">
        <option value="">— Выберите действие —</option>
        <?php foreach ($pageViewModel['actions'] as $key => $value) : ?>
          <option value="<?php echo $key;?>"><?php echo $value;?></option>
        <?php endforeach;?>
      </select>
      <button name="action-submit" type="submit" class="button button--s button--primary">Применить</button>
    </div>

    <!-- table -->
    <table class="product-table table">
      <!-- head -->
      <thead class="product-table__header">
        <tr>
          <th></th>
          <th class="product-table__item product-table__item--title">Наименование</th>
          <th>Бренд</th>
          <th>Категория</th>
          <th>Цена</th>
          <th>Ссылка</th>
          <th>Обновлён</th>
          <th class="product-table__item product-table__item--checkbox">
            <label>
              <input class="table__checkbox-hidden real-checkbox" type="checkbox" name="products[]" data-check="all">
              <span class="table__checkbox-fake custom-checkbox"></span>
            </label>
          </th>
        </tr>
      </thead>
      <!-- head -->

      <!-- body -->
      <tbody class="product-table__body">
        <?php foreach ($pageViewModel['products'] as $product) : ?>
    
          <tr data-status="<?php echo h($product->statu);?>">
            <td class="product-table__img">
              <img 
                src="<?php echo HOST . 'usercontent/products/' . h($product->image_filename);?>" 
                srcset="<?php echo HOST . 'usercontent/products/' . h($product->image_filename);?>" 
                alt="<?php echo h($product->title);?>" loading="lazy"
              >
            </td>
            <td class="product-table__item product-table__item--title">
              <!-- link-to-page -->
              <a class="link-to-page" href="<?php echo HOST . "admin/"; ?>shop-edit/<?php echo u($product->id); ?>">
                <?php echo h($product->title); ?>
              </a>
            </td>
            <td>
              <?php echo h($product->brand_title); ?>
            </td>
            <td>
              <?php echo h($product->category_title ?? '');?>
            </td>
            <td>
              <?php echo h($product->price ?? ''); ?>  &euro;
            </td>
            <td>
              <a class="link link-above-others" href="<?php echo h($product->url);?>">vinted.fr</a>
            </td>
            <td>
              <?php echo h($product->edit_time); ?>
            </td>
            <td class="product-table__item product-table__item--checkbox link-above-others">
              <label>
                <input 
                  class="table__checkbox-hidden real-checkbox" 
                  type="checkbox" 
                  name="products[]" 
                  data-check="<?php echo h($product->id);?>"
                  value="<?php echo h($product->id);?>"
                >
                <span class="table__checkbox-fake custom-checkbox"></span>
              </label>
            </td>
          </tr>
    
              
        <?php endforeach; ?>  

      </tbody>
      <!-- body -->
    </table>
    <!-- table -->
  </form>


  <div class="section-pagination">
    <?php  if ( $pageViewModel['total'] > 0 ) : 
      include ROOT . 'views/_parts/pagination/_pagination.tpl'; 
     endif;  ?>
  </div>
  
</div>

