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


      <div class="profile__body profile__form-wrapper">
        

        <?php if ($uriGet) : ?>
     
          <form class="profile-form" enctype="multipart/form-data" action="<?php echo HOST; ?>profile-edit/<?php echo $uriGet; ?>" method="POST">
         
        <?php else : ?>
          <form class="profile-form" enctype="multipart/form-data" action="<?php echo HOST; ?>profile-edit" method="POST">
        <?php endif; ?>

            <div class="profile-card">
                <?php include ROOT . "views/components/errors.tpl"; ?>
                <?php include ROOT . "views/components/success.tpl"; ?>
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
                                <input id="file" name="avatar" class="block-upload__input-real" type="file" data-preview="input" hidden>
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
                              Имя 
                              <input 
                                class="input input--width-label" 
                                type="text" 
                                placeholder="Введите имя "
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
                                placeholder="Введите фамилию"
                                name="surname"
                                value="<?php echo isset($_POST['surname']) ? $_POST['surname'] : h($userModel->getSurname()); ?>"
                              />
                            </label>
                          </div>
                          <div class="form-group">
                            <label class="input__label">Email 
                              <input 
                                class="input input--width-label" 
                                type="text" placeholder="Введите email"
                                name="email"
                                value="<?php echo isset($_POST['email']) ? $_POST['email'] : h($userModel->getEmail()); ?>"
                              />
                            </label>
                          </div>

                    </div>

                    <!-- CSRF-токен -->
                    <input type="hidden" name="csrf" value="<?php echo h(csrf_token()) ;?>">
                    <!-- // CSRF-токен -->
                  
                  
                </div>

                <div class="form-group">
                  <label class="input__label">Телефон
                    <input 
                      class="input input--width-label" 
                      type="text" placeholder="Введите телефон"
                      name="phone"
                      value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : h($userModel->getPhone()); ?>"
                    />
                  </label>
                  <label class="input__label">Страна
                    <input 
                      class="input input--width-label" 
                      type="text" placeholder="Введите страну"
                      name="country"
                      value="<?php echo isset($_POST['country']) ? $_POST['country'] : h($userModel->getCountry()); ?>"
                    />
                  </label>
                  <label class="input__label">Город
                    <input 
                      class="input input--width-label" 
                      type="text" placeholder="Введите ваш город"
                      name="city"
                      value="<?php echo isset($_POST['city']) ? $_POST['city'] : h($userModel->getCity()); ?>"
                    />
                  </label>
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