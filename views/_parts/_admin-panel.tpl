<div class="admin-panel">

    <div class="admin-panel__block-list">
      <a class="admin-panel__link" href="<?php echo HOST; ?>admin" title="Перейти в панель управления сайтом">
          <div class="admin-panel__icon-wrapper">
            <svg class="icon icon--target">
              <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#target';?>"></use>
            </svg>
          </div>
        <span>Панель управления</span>
      </a>

      <!-- Сообщения -->
      <a class="admin-panel__link" href="<?php echo HOST; ?>admin/messages" title="Перейти списку сообщений">
        <div class="admin-panel__icon-wrapper counter">
          <svg class="icon icon--mail">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#mail';?>"></use>
          </svg>

          <?php 
          if ($adminData['newMessages'] > 0 ) : ?>
            <div class="counter__widget">
              <span class="text-ellipsis">
                  <?php 
                    if ($adminData['newMessages'] <= 10) {
                      echo h( $adminData['newMessages'] );
                    } else {
                      echo '&hellip;';
                    }
                  ?> 
              </span>
            </div>
          <?php endif; 
          ?>
      
        </div>
        <span>Сообщение</span>
      </a>
      <!--// Сообщения -->

      <!-- Заказы -->
      <a class="admin-panel__link" href="<?php echo HOST; ?>admin/orders" title="Перейти к списку заказов">
        <div class="admin-panel__icon-wrapper counter">
          <svg class="icon icon--inventory">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#inventory';?>"></use>
          </svg>
          
          <?php if ($adminData['newOrders'] > 0 ) : ?>
            <div class="counter__widget">
              <span class="text-ellipsis">
                  <?php 
                    if ($adminData['newOrders'] <= 10) {
                      echo h($adminData['newOrders'] );
                    } else {
                      echo '&hellip;';
                    }
                  ?> 
              </span>
            </div>
          <?php endif;?>
  
        </div>
        <span>Заказы</span>
      </a>
      <!--// Заказы -->

    

      <!-- Редактирование текущей страницы -->
      <!-- <?php if ( $uriModule === 'blog' && isset($uriGet) && $uriGet !== 'cat') : ?>
        <a class="admin-panel__link" href="<?php echo HOST . 'admin/post-edit?id=' . u($uriGet); ?>" title='Перейти к редактированию текущей страницы'>
          <div class="admin-panel__icon-wrapper">
            <svg class="icon icon--edit">
              <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#edit';?>"></use>
            </svg>
            
          </div>
          <span>Редактировать</span>
        </a>
      <?php endif; ?> -->

    </div>

    <div class="admin-panel__block-list">
      <a class="admin-panel__link admin-panel__link--avatar" href="<?php echo HOST; ?>profile" title="Перейти на страницу своего профиля">
          <?php if ( !empty($_SESSION['logged_user']['avatar_small'])) : ?>
            <img src="<?php echo HOST . 'usercontent/avatars/' . h($_SESSION['logged_user']['avatar_small']);?>" alt="Перейти на страницу своего профиля">
            <!-- <img src="<?php /** echo HOST; ?>usercontent/avatars/<?php echo $userModel->getAvatar(); */ ?>" alt="Аватарка" /> -->
          <?php else : ?>
            <img src="<?php echo HOST; ?>usercontent/avatars/no-avatar.svg" alt="Аватарка" />
          <?php endif; ?>
      </a>
      <a class="admin-panel__link" href="<?php echo HOST . 'logout';?>" title="Выйти">
        <svg class="icon icon--logout">
          <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#logout';?>"></use>
        </svg>
      </a>
    </div>

</div>




