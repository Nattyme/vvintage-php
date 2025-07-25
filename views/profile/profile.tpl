<main class="page-profile">
  <!-- Если пользователя открывает profile без входа на сайт -->
  <?php if( isset($userNotLoggedIn)) : ?>
    <div class="profile">
			<div class="container">
				<div class="profile__title">
					<h2 class="heading">Профиль пользователя</h2>
          <p>Чтобы посмотреть свой профиль
            <a href="<?php echo HOST; ?>login">войдите</a>
            либо
            <a href="<?php echo HOST; ?>registration">зарегистрируйтесь</a>
          </p>
				</div>
			</div>
		</div>
  <!-- Если пользователя с таким ID не существует -->
  <?php elseif (!$userModel || isset($userModel) && $userModel->getId() === 0) : ?>
    <div class="profile">
			<div class="container">
				<div class="profile__title">
					<h2 class="heading">Такого пользователя не существует</h2>
          <p><a href="<?php echo HOST; ?>">Вернуться на главную</a></p>
				</div>
			</div>
		</div>
  <!--// Если пользователя с таким ID не существует -->
  
  <!-- Если пользователь НАЙДЕН -->
  <?php else : ?>
    <section class="profile">
			<div class="container">
				<div class="profile__title">
					<h2 class="h2">Профиль пользователя </h2>
				</div>
				<div class="profile__body">
          <div class="notifications-wrapper">
            <div class="notifications-wrapper__row">
              <?php include ROOT . "views/components/errors.tpl"; ?>
              <?php include ROOT . "views/components/success.tpl"; ?>
            </div>
          </div>

          <!-- Блок пустого профиля -->
          <?php if (empty($userModel->getName())) : ?>
            <div class="profile__row profile__wrapper">
              <div class="col-md-6">
                <div class="enter-or-reg flex-column flex-row-gap">
                  <div class="enter-or-reg__text">
                      Пустой профиль 😑 
                  </div>
                  <!-- Кнопка редактирования профиля -->
                  <?php include ROOT . "views/profile/_parts/_button-edit-profile.tpl"; ?>
                </div>
              </div>
            </div>
          <!-- Заполненный профиль -->
          <?php else : ?>
            <div class="profile__row">
              <div class="profile__column profile__column--img">
                <div class="avatar-big avatar-big-wrapper">
                  <?php if ( !empty($userModel->getAvatar())) : ?>
                    <img src="<?php echo HOST; ?>usercontent/avatars/<?php echo $userModel->getAvatar(); ?>" alt="Аватарка" />
                  <?php else : ?>
                    <img src="<?php echo HOST; ?>usercontent/avatars/no-avatar.svg" alt="Аватарка" />
                  <?php endif; ?>
                </div>
              </div>
              <div class="profile__column profile__column--desc ">
                <div class="profile__definition-list">
                  <?php if (!empty($userModel->getName())) : ?>
                    <dl class="definition">
                      <dt class="definition__term">имя и фамилия</dt>
                      <dd class="definition__description">
                        <?php echo $userModel->getName(); ?> 
                        <?php echo $userModel->getSurname(); ?>
                      </dd>
                    </dl>
                  <?php endif; ?>

                  <?php if (!empty($userModel->getCountry) || !empty($userModel->getCity)) : ?>
                    <dl class="definition">
                      <dt class="definition__term">
                        <?php if (!empty($userModel->getCountry)) : ?>
                          Страна
                        <?php endif; ?>

                        <?php if (!empty($userModel->getCountry()) && !empty($userModel->getCity())) : ?>
                          ,
                        <?php endif; ?>

                        <?php if (!empty($userModel->getCity())) : ?>
                          город
                        <?php endif; ?>
                      </dt>
                      <dd class="definition__description">
                        <?php echo $userModel->getCountry(); ?> 
                        <?php if (!empty($userModel->getCountry()) && !empty($userModel->getCity())) : ?>
                          ,
                        <?php endif; ?>
                        <?php echo $userModel->getCity(); ?>
                      </dd>
                    </dl>
                  <?php endif; ?>

                  <!-- Видно только владельцу профиля или админу -->
                  <?php 
                    if ( isset($_SESSION['logged_user']) && 
                        ($_SESSION['logged_user']['id'] === $user['id'] || $_SESSION['logged_user']['role'] === 'admin') 
                      ) : 
                  ?>
                      <dl class="definition">
                        <?php if ( !empty($user->phone)) : ?>
                          <dt class="definition__term">
                            Номер телефона
                          </dt>
                          <dd class="definition__description">
                            <?php echo $userModel->getPhone(); ?> 
                          </dd>
                        <?php endif; ?>
                      </dl>
                      <dl class="definition">
                        <?php if ( !empty($userModel->getAddress()) ) : ?>
                          <dt class="definition__term">
                            Адрес доставки заказов
                          </dt>
                          <dd class="definition__description">
                            <?php echo $userModel->getAddress(); ?> 
                          </dd>
                        <?php endif;?>
                      </dl>
                  <?php 
                    endif; 
                  ?>
                  <!-- // Видно только владельцу профиля или админу-->
                </div>
                <!-- Кнопка редактирования профиля -->
                <?php include ROOT . "views/profile/_parts/_button-edit-profile.tpl"; ?>
              </div>
                <!-- // Выводим заказы пользователя (если есть) -->
            <?php if ( isset($orders) && !empty($orders) ) { 
              include ROOT . 'views/profile/_parts/user-orders.tpl'; 
            };?>
					  </div>
          <?php endif; ?>
				</div>
			</div>
		</section>
    <?php 

      // // Выводим заказы пользователя (если есть)
      // if ( isset($orders) && !empty($orders) ) { 
      //   include ROOT . 'templates/profile/_parts/user-orders.tpl'; 
      // }

      // Выводим комментарии пользователя (если есть)
      if ( isset($comments) && !empty($comments) ) { 
        include ROOT . 'templates/profile/_parts/user-comments.tpl'; 
      }
      
    ?>
  <?php endif; ?>
  <!--// Если пользователь НАЙДЕН -->
</main>