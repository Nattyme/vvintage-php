<div class="admin-page__content-form">
  <div class="admin-form">
    <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
    <?php include ROOT . "admin/templates/components/success.tpl"; ?>

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
            value="<?php echo h($searchQuery);?>"
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
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Заголовок</th>
          <th>Содержание</th>
          <th>Обложка</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($posts as $post) : ?>
          <tr>
            <td><?php echo $post['id']; ?></td>
            <td>
              <a class="link-to-page" href="<?php echo HOST . "admin/"; ?>post-edit?id=<?php echo $post['id']; ?>">
                <?php echo h(shortText($post['title'], $limit = 50));?>"
              </a>
            </td>
            <td>
              <?php echo shortText($post['content'], $limit = 50);?>"
            </td>
            <td>
              <img src="<?php echo HOST . 'usercontent/blog/' . h($post['cover_small']);?>" alt="<?php echo h(shortText($post['title'], $limit = 50));?>">
            </td>
            <td>
              <a href="<?php echo HOST . "admin/";?>post-delete?id=<?php echo $post['id'];?>" class="icon-delete"></a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Пагинация -->
  <div class="section-pagination">
    <?php include ROOT . "admin/templates/_parts/pagination/_pagination.tpl"; ?>
  </div>
  <!--// Пагинация -->
</div>
