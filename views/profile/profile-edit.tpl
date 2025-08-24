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
         
        <?php include ROOT . 'views/profile/_parts/_profile-edit-tabs.tpl';?>
          
         
          </form>
      </div>
       
     
    </div>
  </section>
  <?php endif; ?>
</main>