<?php if( isset($_SESSION['logged_user']) && $_SESSION['logged_user']['role'] === 'admin') : ?>
  <div class="admin-panel">
 
      <div class="admin-panel__block-list">
        <a class="admin-panel__link" href="<?php echo HOST; ?>admin" title="Перейти в панель управления сайтом">
            <div class="admin-panel__item">
              <svg class="icon icon--target">
                <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#target';?>"></use>
              </svg>
            </div>
          <span>Панель управления</span>
        </a>

        <!-- Сообщения -->
        <a class="admin-panel__link" href="<?php echo HOST; ?>admin/messages" title="Перейти списку сообщений">
          <div class="admin-panel__item">
            <svg class="icon icon--mail">
              <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#mail';?>"></use>
            </svg>

            <?php if ($messagesNewCounter > 0 ) : ?>
              <div class="admin-panel__item-icon">
                <?php 
                  if ($messagesNewCounter <= $messagesDisplayLimit) {
                    echo $messagesNewCounter;
                  } else {
                    echo '&hellip;';
                  }
                ?> 
              </div>
            <?php endif;?>
          </div>
          <span>Сообщение</span>
        </a>
        <!--// Сообщения -->

        <!-- Заказы -->
        <a class="admin-panel__link" href="<?php echo HOST; ?>admin/orders" title="Перейти к списку заказов">
          <div class="admin-panel__item">
            <svg class="icon icon--folder">
              <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#folder';?>"></use>
            </svg>
    
          </div>
          <span>Заказы</span>
        </a>
        <!--// Заказы -->

        <!-- Комментарии -->
        <a class="admin-panel__link" href="<?php echo HOST . 'admin/comments';?>" title="Перейти к списку комментариев">
          <div class="admin-panel__item">
            <svg class="icon icon--message-square">
              <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#message-square';?>"></use>
            </svg>
          </div>
          <span>Комментарии</span>
        </a>
        <!--// Комментарии -->

        <!-- Редактирование текущей страницы -->
        <?php if ( $uriModule === 'blog' && isset($uriGet) && $uriGet !== 'cat') : ?>
          <a class="admin-panel__link" href="<?php echo HOST . 'admin/post-edit?id=' . $uriGet; ?>" title='Перейти к редактированию текущей страницы'>
            <div class="admin-panel__item">
              <svg class="icon icon--edit">
                <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#edit';?>"></use>
              </svg>
             
            </div>
            <span>Редактировать</span>
          </a>
        <?php endif; ?>

      </div>

      <div class="admin-panel__block-list">
        
        <a class="admin-panel__link admin-panel__link--avatar" href="<?php echo HOST; ?>profile" title="Перейти на страницу своего профиля">
            <img src="<?php echo HOST . 'usercontent/avatars/' . $_SESSION['logged_user']['avatarSmall'];?>" alt="">
        </a>
        <a class="admin-panel__link" href="<?php echo HOST . 'logout';?>" title="Выйти">
          <svg class="icon icon--logout">
            <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#logout';?>"></use>
          </svg>
        </a>
      </div>
  
  </div>

<?php elseif (isset($_SESSION['logged_user']) && trim($_SESSION['logged_user']) !== '' && $_SESSION['logged_user']['role'] !== 'admin') : ?>
  <div class="admin-panel">
    <div class="admin-panel__nav">

      <div class="admin-panel__block-list">
          <a class="admin-panel__link admin-panel__link--avatar" href="<?php echo HOST . 'profile';?>" title="Перейти в профиль">
            <img src="<?php echo HOST . 'usercontent/avatars/' . $_SESSION['logged_user']['avatarSmall'];?>" alt="">
          </a>
          <a class="admin-panel__link" href="<?php echo HOST . 'logout';?>" title="Выйти">
            <svg class="icon icon--logout">
              <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#logout';?>"></use>
            </svg>
          </a>
      </div>
    </div>
  </div>
        

<?php else : ''; ?>
<?php endif; ?>


