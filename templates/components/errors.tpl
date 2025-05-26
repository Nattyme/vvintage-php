<?php
//Проверка, что массив $errors не пустой, значит есть ошибки на вывод
  if ( !empty($_SESSION['errors']) ) :
    //Обходим массив, выводя каждую ошибку
    foreach ($_SESSION['errors'] as $error) :
      //Если в ошибке только заголовок
      if ( count($error) == 1 ) : ?>
        <div class="notifications">
          <div class="notifications__title notifications__title--error"><?php echo h($error['title']); ?></div>
        </div>
        <!-- Если в ошибке только заголовок с описанием -->
      <?php elseif ( count($error) == 2 ) : ?>
        <div class="notifications notifications__title--with-message">
          <div class="notifications__title notifications__title--error"><?php echo h($error['title']); ?>
           
          </div>
          <div class="notifications__message">
            <p><?php echo h($error['desc']); ?> </p>     
          </div>
        </div>
      <?php endif;
    endforeach;
    $_SESSION['errors'] = array();
  endif;