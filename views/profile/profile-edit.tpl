<main class="page-profile">
  <?php if ( $userModel->getId() === 0) : ?>
  <section class="profile">
    <div class="container">
      <div class="profile__title">
        <h2 class="h2 mb-25">Профиль пользователя</h2>
        <p>Чтобы посмотреть свой профиль
          <a href="<?php echo HOST; ?>login">войдите</a>
          либо
          <a href="<?php echo HOST; ?>registration">зарегистрируйтесь</a>
        </p>
      </div>
    </div>
  </section>
  <?php else: ?>
  <section class="profile">
    <div class="container">
      <div class="profile__title">
        <h2 class="h2">Редактировать профиль </h2>
      </div>

      <div class="profile__body profile__form-wrapper">
        <?php if (isset($uriGet)) : ?>
     
          <form class="profile-form" enctype="multipart/form-data" action="<?php echo HOST; ?>profile-edit/<?php echo $uriGet; ?>" method="POST">
        <?php else : ?>
          <form class="profile-form" enctype="multipart/form-data" action="<?php echo HOST; ?>profile-edit" method="POST">
        <?php endif; ?>





              <section class="profile-card">
                <div class="profile-card__header">
                  <div class="profile-card__avatar">
                    <?php if (!empty($userModel->getAvatar())) : ?>
                      <img src="<?php echo HOST; ?>usercontent/avatars/<?php echo $userModel->getAvatar(); ?>" alt="Аватарка">
                    <?php else : ?>
                      <img src="<?php echo HOST; ?>usercontent/avatars/no-avatar.svg" alt="Аватарка">
                    <?php endif; ?>
                  </div>
                  <div class="profile-card__user">
                    <div class="profile-card__name">
                      <?php echo $userModel->getName(); ?> <?php echo $userModel->getSurname(); ?>
                    </div>
                    <div class="profile-card__role">Роль: <?php echo h( $userModel->getRole());?></div>
                  </div>

                <?php
                  if ($this->isAdmin()) {
                    echo "<a class=\"button button--s button--primary\" href=\"" . HOST . "profile-edit/". $userModel->getId() ."\">Редактировать</a>";
                  }
                  else  {
                      echo "<a class=\"button button--s button--primary\" href=\"" . HOST . "profile-edit\">Редактировать</a>";
                  }
                ?>

                </div>

                <div class="profile-card__body">
                  <dl class="profile-card__list">
                    <div class="profile-card__row">
                      <dt>Электронная почта</dt>
                      <dd><?php echo h($userModel->getEmail()); ?></dd>
                    </div>
                    <div class="profile-card__row">
                      <dt>Телефон</dt>
                      <dd><?php echo h($userModel->getPhone()); ?></dd>
                    </div>
                    <div class="profile-card__row">
                      <dt>Страна</dt>
                      <dd><?php echo $userModel->getCountry(); ?></dd>
                    </div>
                    <div class="profile-card__row">
                      <dt>Город</dt>
                      <dd><?php echo $userModel->getCity(); ?></dd>
                    </div>
                  </dl>
                </div>
              </section>

              <!-- // Выводим заказы пользователя (если есть) -->
              <section class="profile-orders">
                <?php if ( $orders) : ?>
                    <?php include (ROOT . 'views/profile/_parts/user-orders.tpl'); ?>
                <?php endif;?>
              </section>
          
         
          </form>
      </div>
       
     
    </div>
  </section>
  <?php endif; ?>
</main>