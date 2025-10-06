<!-- <main class="page-profile">
  <section class="profile-card">
      <div class="container">
      <div class="profile-card__header">
        <div class="profile-card__avatar">
          <?php if (!empty($userModel->getAvatar())) : ?>
            <img src="<?php echo HOST; ?>usercontent/avatars/<?php echo $userModel->getAvatar(); ?>" alt="<?php echo h(__('profile.avatar', [], 'profile'));?>">
          <?php else : ?>
            <img src="<?php echo HOST; ?>usercontent/avatars/no-avatar.svg" alt="<?php echo h(__('profile.avatar', [], 'profile'));?>">
          <?php endif; ?>
        </div>
        <div class="profile-card__user">
          <div class="profile-card__name">
            <?php echo $userModel->getName(); ?> <?php echo $userModel->getSurname(); ?>
          </div>
          <div class="profile-card__role">
            <?php echo h(__('profile.user_role', [], 'profile'));?>
          </div>
        </div>
      </div>

      <div class="profile-card__body">
        <dl class="profile-card__list">
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
      </div>
    </div>
  </section>
</main> -->
