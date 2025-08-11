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
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Заголовок</th>
          <th>Содержание</th>
          <th>Обложка</th>
          <th>Создан</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($postViewModel['posts'] as $post) : ?>
          <tr>
            <td><?php echo h( $post->getId() ); ?></td>
            <td>
              <a class="link-to-page" href="<?php echo HOST . "admin/"; ?>post-edit/<?php echo h( $post->getId() ); ?>">
                <?php echo h(shortText($post->getTitle(), $limit = 50));?>"
              </a>
            </td>
            <td>
              <?php echo h( shortText($post->getDescription(), $limit = 50) );?>"
            </td>
            <td>
              <img 
                src="<?php echo HOST . 'usercontent/blog/' . h($post->getCoverSmall() );?>" 
                alt="<?php echo h(shortText($post->getTitle(), $limit = 50));?>">
            </td>
            <td>
              <?php echo h(rus_date('j. m. Y. H:i', $post->getDateTime()->getTimestamp()));?>
            </td>
            <td>
              <a 
                class="button button-close cross-wrapper cart__delete link-above-others"   
                href="<?php echo HOST . "admin/";?>post-delete/<?php echo h($post->getId());?>"
                aria-label="Удалить статью <?php echo h($post->getTitle());?>"
              >

                  <span class="leftright"></span><span class="rightleft"> </span>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Пагинация -->
  <div class="section-pagination">
    <?php include ROOT . "views/_parts/pagination/_pagination.tpl"; ?>
  </div>
  <!--// Пагинация -->
</div>
