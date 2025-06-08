<div class="admin-page__content-form">
  <div class="admin-form">
    <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
    <?php include ROOT . "admin/templates/components/success.tpl"; ?>

    <header class="admin-form__header admin-form__row">
      <a href="<?php HOST . 'brand-new';?>" class="button button--m button--primary" data-btn="new">
        <span>Написать</span>
      </a>
      <form method="GET" action="" class="shop__search search" role="search">
        <input type="text" name="query" placeholder="Найти">
        <button type="search-submit">
          <svg class="icon icon--loupe">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#loupe';?>"></use>
          </svg>
        </button>
      </form>
    </header>


    <!-- Таблица -->
    <table class="admin-form-table table">
      <thead class="product-table__header">
        <tr>
          <th>ID</th>
          <th>Отправитель</th>
          <th>Email</th>
          <th>Текст</th>
          <th>Время</th>
          <th>Файл</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($messages as $message) : ?>

          <tr class="admin-form-table__row <?php echo $message['status'] === 'new' ? 'message-new' : NULL;?>">
            <td class="admin-form-table__unit">
              <?php echo $message['id'];?>
            </td>
            <td class="admin-form-table__unit block-text">
              <a class="link-to-page" href="<?php echo HOST;?>admin/message?id=<?php echo $message['id'];?>">
                <p class="block-text__desc"><?php echo h($message['name']);?></p>
              </a>
            </td>
            <td class="admin-form-table__unit">
              <?php echo h($message['email']);?>
            </td>
            <td class="admin-form-table__unit block-text">
              <p class="block-text__desc"><?php echo h($message['message']);?></p>
            </td>
            <td class="admin-form-table__unit">
              <?php echo h(rus_date("j. m. Y. H:i", $message['timestamp'])); ?>
            </td>
            <td class="admin-form-table__unit">
              <a target="_blank" href="<?php echo HOST . 'usercontent/contact-form/' . h($message['fileNameSrc']);?>"><?php echo isset($message['fileNameOriginal']) ? h($message['fileNameOriginal']) : '-';?></a>
            </td>
            <td class="admin-form-table__unit">
              <a href="<?php echo HOST . 'admin/message-delete?id=' . u($message['id']);?>" class="button button-close cross-wrapper cart__delete link-above-others " 
                aria-label="Удалить товар <?php echo h($message['id']);?>">
                <span class="leftright"></span><span class="rightleft"> </span>
              </a>
            </td>
          </tr>
          
        <?php endforeach; ?> 
      </tbody>
    </table>
    <!--// Таблица -->
    
    <!-- Пагинация -->
    <?php include ROOT . "admin/templates/_parts/pagination/_pagination.tpl"; ?>
    <!--// Пагинация -->
  </div>
</div>
