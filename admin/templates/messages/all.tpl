<div class="admin-page__content-form">
  <div class="admin-form">
    <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
    <?php include ROOT . "admin/templates/components/success.tpl"; ?>

    <!-- Заголовок -->
    <div class="admin-form__item admin-form__title">
      <h2 class="heading">Сообщения</h2>
    </div>
    <!-- Заголовок -->

    <!-- Таблица -->
    <table class="admin-form-table">
      <thead class="admin-form-table__header">
        <tr class="admin-form-table__row">
          <th class="admin-form-table__unit">ID</th>
          <th class="admin-form-table__unit">Отправитель</th>
          <th class="admin-form-table__unit">Email</th>
          <th class="admin-form-table__unit">Текст</th>
          <th class="admin-form-table__unit">Время</th>
          <th class="admin-form-table__unit">Файл</th>
          <th class="admin-form-table__unit"></th>
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
                <p class="block-text__desc"><?php echo $message['name'];?></p>
              </a>
            </td>
            <td class="admin-form-table__unit">
              <?php echo $message['email'];?>
            </td>
            <td class="admin-form-table__unit block-text">
              <p class="block-text__desc"><?php echo $message['message'];?></p>
            </td>
            <td class="admin-form-table__unit">
              <?php echo rus_date("j. m. Y. H:i", $message['timestamp']); ?>
            </td>
            <td class="admin-form-table__unit">
              <a target="_blank" href="<?php echo HOST . 'usercontent/contact-form/' . $message['fileNameSrc'];?>"><?php echo $message['fileNameOriginal']; ?></a>
            </td>
            <td class="admin-form-table__unit">
              <a href="<?php echo HOST . "admin/";?>messages?action=delete&id=<?php echo $message['id'];?>" class="link-above-others icon-delete">
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
    <?php include ROOT . "admin/templates/_parts/pagination/_pagination.tpl"; ?>
    <!--// Пагинация -->
  </div>
</div>
