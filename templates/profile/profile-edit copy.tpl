<main class="page-profile">
  <?php if ( $user['id'] === 0) : ?>
  <section class="profile">
    <div class="container">
      <div class="profile__title">
        <h2 class="heading mb-25">Профиль пользователя</h2>
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
        <h2 class="heading">Редактировать профиль </h2>
      </div>

      <div class="profile__body">
          <?php if (isset($uriGet)) : ?>
            <form class="profile-form" enctype="multipart/form-data" action="<?php echo HOST; ?>profile-edit/<?php echo $uriGet; ?>" method="POST">
          <?php else : ?>
            <form class="profile-form" enctype="multipart/form-data" action="<?php echo HOST; ?>profile-edit" method="POST">
          <?php endif; ?>
              <div class="profile-form__row">
                <div class="col-md-8">
                  <?php include ROOT . "templates/components/errors.tpl"; ?>
                  <?php include ROOT . "templates/components/success.tpl"; ?>
                  <div class="form-group">
                    <label class="input__label">
                      Введите имя 
                      <input 
                        class="input input--width-label" 
                        type="text" 
                        placeholder="Имя"
                        name="name"
                        value="<?php echo isset($_POST['name']) ? $_POST['name'] : $user->name; ?>" 
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
                        value="<?php echo isset($_POST['surname']) ? $_POST['surname'] : $user->surname; ?>"
                      />
                    </label>
                  </div>
                  <div class="form-group">
                    <label class="input__label">Введите email 
                      <input 
                        class="input input--width-label" 
                        type="text" placeholder="Email"
                        name="email"
                        value="<?php echo isset($_POST['email']) ? $_POST['email'] : $user->email; ?>"
                      />
                    </label>
                  </div>
                </div>
              </div>

              <div class="profile-form__row">
                <div class="profile-form__img profile-form__column">
                  <div class="avatar-big">
                    <?php if ( !empty($user->avatar)) : ?>
                      <img src="<?php echo HOST; ?>usercontent/avatars/<?php echo $user->avatar; ?>" alt="Аватарка" />
                    <?php else : ?>
                      <img src="<?php echo HOST; ?>usercontent/avatars/no-avatar.svg" alt="Аватарка" />
                    <?php endif; ?>
                  </div>
                </div>
                <div class="profile-form__upload profile-form__column">
                  <div class="block-upload">
                    <div class="block-upload__description">
                      <div class="block-upload__title">Фотография</div>
                      <p>Изображение jpg или png, рекомендуемая ширина 160px и больше, высота от 160px и более. Вес до 4Мб.</p>
                      <div class="block-upload__file-wrapper">
                        <input name="avatar" class="file-button" type="file">
                      </div>
                    </div>
                  </div>
                  <?php /* if ( !empty($user->avatar)) : */ ?>
                    <label class="checkbox__item mt-15">
                      <input class="checkbox__btn" type="checkbox" name="delete-avatar">
                      <span class="checkbox__label">Удалить фотографию</span>
                    </label>
                  <?php /* endif; */ ?>
                </div>
              </div>

              

              <div class="form-group form-group--buttons-left">
                <button name="updateProfile" class="button-solid" type="submit">Сохранить</button>
                <a class="button-outline" href="<?php echo HOST; ?>profile">Отмена</a>
              </div>
              
            
            </form>
        
       
      </div>
    </div>
  </section>
  <?php endif; ?>
</main>