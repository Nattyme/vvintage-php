<?php 

  if ( !empty($_SESSION['success']) ) :
    foreach ($_SESSION['success'] as $result) :
      if ( count($result) == 1) :?>
        <div class="notifications">
          <div class="notifications__title notifications__title--success"><?php echo $result['title']; ?></div>
        </div>
      <?php elseif ( count($result) == 2 ) : ?>
        <div class="notifications notifications__title--with-message">
          <div class="notifications__title notifications__title--success"><?php echo $result['title']; ?></div>
          <div class="notifications__message">
              <?php echo $result['desc']; ?>            
          </div>
        </div>
      <?php endif;
    endforeach;
    $_SESSION['success'] = array();
  endif;