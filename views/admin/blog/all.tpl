<div class="admin-page__content-form">
  <div class="admin-form">
    <?php include ROOT . "views/components/errors.tpl"; ?>
    <?php include ROOT . "views/components/success.tpl"; ?>

    <header class="admin-form__header">
      <div class="admin-form__field admin-form__row">
        <a class="button button--s button--primary" href="<?php echo HOST . 'admin/post-new';?>">Добавить пост</a>
      
        <!-- SEARCH FORM-->
        <form method="GET" action="" class="search" role="search">
          <label for="query" class="visually-hidden">Найти</label>
          <input 
            type="text" 
            name="query" 
            placeholder="Найти" 
            value="<?php /* echo h($searchQuery) */;?>"
          >

          <button type="search-submit">
            <svg class="icon icon--loupe">
              <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#loupe';?>"></use>
            </svg>
          </button>
        </form>
        <!-- SEARCH FORM-->
      </div>

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
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Заголовок</th>
            <th>Содержание</th>
            <th>Обложка</th>
            <th>Создан</th>
            <th>
                
              <label>
                <input 
                  class="table__checkbox-hidden real-checkbox" 
                  type="checkbox" 
                  name="posts[]" 
                  data-check-all
                >
                <span class="table__checkbox-fake custom-checkbox"></span>
              </label>
         
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($pageViewModel['posts'] as $post) : ?>
            <tr>
              <td><?php echo h( $post->id ); ?></td>
              <td>
                <a class="link-to-page" href="<?php echo HOST . "admin/"; ?>post-edit/<?php echo h( $post->id ); ?>">
                  <?php echo h(shortText($post->title, $limit = 50));?>"
                </a>
              </td>
              <td>
                <?php echo h( shortText($post->description, $limit = 50) );?>"
              </td>
              <td>
                <img 
                  src="<?php echo HOST . 'usercontent/blog/' . h($post->cover_small );?>" 
                  alt="<?php echo h(shortText($post->title, $limit = 50));?>">
              </td>
              <td>
                <?php echo $post->formatted_date;?>
              </td>
              <td class="product-table__item product-table__item--checkbox link-above-others">
                <label>
                  <input 
                    class="table__checkbox-hidden real-checkbox" 
                    type="checkbox" 
                    name="products[]" 
                    data-check="<?php echo h($post->id);?>"
                    value="<?php echo h($post->id);?>"
                  >
                  <span class="table__checkbox-fake custom-checkbox"></span>
                </label>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </form>
  </div>

  <!-- Пагинация -->
  <div class="section-pagination">
    <?php include ROOT . "views/_parts/pagination/_pagination.tpl"; ?>
  </div>
  <!--// Пагинация -->
</div>
