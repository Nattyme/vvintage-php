<main class="page-profile  inner-page">
  <div class="page-profile__content">
    <div class="container">
      <!-- Заголовок и хлебные крошки -->
      <?php include ROOT . 'views/_parts/_inner-header.tpl'; ?>
      
      <div class="profile-card">
        <div class="notifications-wrapper">
          <?php include ROOT . "views/components/errors.tpl"; ?>
          <?php include ROOT . "views/components/success.tpl"; ?>
        </div>


        <section class="profile-card__header">
            <div class="profile-card__avatar">
              <div class="avatar-big">
                <?php if ( !empty($userModel->getAvatar()) && file_exists(ROOT . 'usercontent/avatars/' . $userModel->getAvatar())) : ?>
                  <img src="<?php echo HOST; ?>usercontent/avatars/<?php echo $userModel->getAvatar(); ?>" alt="<?php echo h(__('profile.avatar', [], 'profile'));?>">
                <?php else : ?>
                  <img src="<?php echo HOST; ?>usercontent/avatars/no-avatar.svg" alt="<?php echo h(__('profile.avatar', [], 'profile'));?>">
                <?php endif; ?>
              </div>
            </div>
            <div class="profile-card__user">
              <div class="profile-card__name">
                <?php echo $userModel->getName(); ?> <?php echo $userModel->getSurname(); ?>
              </div>
              <div class="profile-card__role">Роль: <?php echo h( $userModel->getRole());?></div>
            </div>

            <?php if ($this->isAdmin()) :?>
              <div class="profile-card__button-wrapper">
                <a class="button button--s button--primary" href="<?php echo HOST . 'profile/edit/'. u($userModel->getId());?>">
                  <?php echo h(__('profile.edit', [], 'profile'));?>
                </a>
              </div>
            <?php else  : ?>
              <div class="profile-card__button-wrapper">
                <a class="button button--s button--primary" href="<?php echo HOST . 'profile/edit';?>">
                  <?php echo h(__('profile.edit', [], 'profile'));?>
                </a>
              </div>
            <?php endif; ?>

        </section>

        <section class="profile-card__body">
          <dl class="profile-card__list">
            <div class="profile-card__row">
              <dt>
                <?php echo h(__('profile.email', [], 'profile'));?>
              </dt>
              <dd><?php echo h($userModel->getEmail()); ?></dd>
            </div>
            <div class="profile-card__row">
              <dt>
                <?php echo h(__('profile.phone', [], 'profile'));?>
              </dt>
              <dd><?php echo h($userModel->getPhone()); ?></dd>
            </div>
            <div class="profile-card__row">
              <dt>
                <?php echo h(__('profile.country', [], 'profile'));?>
              </dt>
              <dd><?php echo $userModel->getCountry(); ?></dd>
            </div>
            <div class="profile-card__row">
              <dt>
                <?php echo h(__('profile.city', [], 'profile'));?>
              </dt>
              <dd><?php echo $userModel->getCity(); ?></dd>
            </div>
          </dl>
        </section>
             <!-- // Выводим заказы пользователя (если есть) -->
    <section class="profile-orders">
      <div class="container">
        <?php if ( $orders) : ?>
            <?php include (ROOT . 'views/profile/_parts/user-orders.tpl'); ?>
        <?php endif;?>
      </div>
    </section>
      </div>
    </div>


 

  </div>
</main>
