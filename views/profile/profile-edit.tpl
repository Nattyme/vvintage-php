<main class="page-profile">
  <?php if ( $userModel->getId() === 0) : ?>
  <section class="profile">
    <div class="container">
      <div class="profile__title">
        <h2 class="h2">Профиль пользователя</h2>
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

      <?php include ROOT . "templates/components/errors.tpl"; ?>
      <?php include ROOT . "templates/components/success.tpl"; ?>

      <div class="profile__body profile__form-wrapper">
        <?php if (isset($uriGet)) : ?>
     
          <form class="profile-form" enctype="multipart/form-data" action="<?php echo HOST; ?>profile-edit/<?php echo $uriGet; ?>" method="POST">
        <?php else : ?>
          <form class="profile-form" enctype="multipart/form-data" action="<?php echo HOST; ?>profile-edit" method="POST">
        <?php endif; ?>

            <div class="profile-card">
                <div class="profile-card__content">
              
                    <div class="profile-column profile-column--img">
                          <div class="profile__user-avatar">
                            <div class="avatar-big">
                                <?php if ( !empty($userModel->getAvatar())) : ?>
                                  <img src="<?php echo HOST; ?>usercontent/avatars/<?php echo $userModel->getAvatar(); ?>" alt="Аватарка" />
                                <?php else : ?>
                                  <img src="<?php echo HOST; ?>usercontent/avatars/no-avatar.svg" alt="Аватарка" />
                                <?php endif; ?>

                                <!-- Кастомная кнопка -->
                                <button type="button" class="btn-add-photo" id="btn-add-photo">
                                    <svg class="icon icon--add_photo">
                                      <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#add_photo';?>"></use>
                                    </svg>
                                </button>
                                <input id="file" name="cover[]" class="block-upload__input-real" type="file" multiple data-preview="input" hidden>
                            </div>
    
                          </div>
          

                          <?php  if ( !empty($userModel->getAvatar())) :  ?>
                            <label class="checkbox__item mt-15">
                              <input class="checkbox__btn" type="checkbox" name="delete-avatar">
                              <span class="checkbox__label">Удалить фотографию</span>
                            </label>
                          <?php  endif;  ?>
                    </div>
                    <div class="profile-column">
                          <div class="form-group">
                            <label class="input__label">
                              Введите имя 
                              <input 
                                class="input input--width-label" 
                                type="text" 
                                placeholder="Имя"
                                name="name"
                                value="<?php echo isset($_POST['name']) ? $_POST['name'] : h($userModel->getName()); ?>" 
                              />
                            </label>
                          </div>
                          <div class="form-group">
                            <label class="input__label">
                              Введите фамилию 
                              <input 
                                class="input input--width-label" 
                                type="text" 
                                placeholder="Фамилия"
                                name="surname"
                                value="<?php echo isset($_POST['surname']) ? $_POST['surname'] : h($userModel->getSurname()); ?>"
                              />
                            </label>
                          </div>
                          <div class="form-group">
                            <label class="input__label">Введите email 
                              <input 
                                class="input input--width-label" 
                                type="text" placeholder="Email"
                                name="email"
                                value="<?php echo isset($_POST['email']) ? $_POST['email'] : h($userModel->getEmail()); ?>"
                              />
                            </label>
                          </div>

                    </div>
                  
                  
                </div>
          

                <div class="profile-form__row">
                  <button name="updateProfile" class="button button--primary button--s" type="submit">Сохранить</button>
                  <a class="button button--outline button--s" href="<?php echo HOST; ?>profile">Отмена</a>
                </div>
            </div>



              <!-- // Выводим заказы пользователя (если есть) -->
            <?php if ( isset($orders) and !empty($orders)) : ?>
              <section class="profile-orders">
                <?php include (ROOT . 'views/profile/_parts/user-orders.tpl'); ?>
              </section>
            <?php endif;?>

          </form>
      </div>
       
     
    </div>
  </section>
  <?php endif; ?>
</main>