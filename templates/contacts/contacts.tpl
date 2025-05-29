<main class="inner-page">
  <section class="contacts">
    <div class="container">
      <div class="contacts__header">
        <div class="section-title">
          <h1 class="h1">Контакты</h1>
        </div>
        <?php include 'templates/_parts/breadcrumbs/breadcrumbs.tpl';?>
      </div>
      <div class="contacts__map-wrapper">
        <div class="contacts__map" id="map" style="width: 100%; height: 476px">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2715.862570042332!2d2.3689981761541183!3d47.10176477114796!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47fa95928344d14f%3A0x25e4e1099de4acfb!2zNyBSdWUgQWxhaW4gRm91cm5pZXIsIDE4MjMwIFNhaW50LURvdWxjaGFyZCwg0KTRgNCw0L3RhtC40Y8!5e0!3m2!1sru!2sde!4v1748543016031!5m2!1sru!2sde" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>
      <div class="contacts__widgets-wrapper">
            <div class="contacts__widget">
              <h3 class="contacts__widget__title h3">Контакты</h3>
              <ul class="contacts__list">
                <li class="contacts__item">
                  <svg class="icon icon--phone">
                    <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#phone';?>"></use>
                  </svg>
                  <a href="tel:+330606459426" class="contacts__link">+33-0606459426</a>
                </li>
 
                <li class="contacts__item">
                  <svg class="icon icon--mail">
                    <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#mail';?>"></use>
                  </svg>
                  <a href="mailto:vvintage.store@yandex.com" class="contacts__link">vvintage.store@yandex.com</a>
                </li>
                <li class="contacts__item">
                  <svg class="icon icon--location">
                    <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#location';?>"></use>
                  </svg>
                  <p>7 Rue Alain Fournier, 18230 Saint-Doulchard, France</p>
                </li>
              </ul>
            </div>

            <div class="contacts__widget">
              <h3 class="contacts__widget__title h3">Напишите нам</h3>
              <?php include ROOT . "templates/components/errors.tpl"; ?>
              <?php include ROOT . "templates/components/success.tpl"; ?>
              <div class="contacts__form">
                <form action="<?php echo HOST . 'contacts';?>" class="form-contact" method="POST">
                  <div class="form-input-wrapper">
                    <input type="text" class="form-input input" placeholder="Имя" name="name" />
                    <input type="text" class="form-input input" placeholder="E-mail" name="email" />
                    <input type="text" class="form-input input" placeholder="Телефон" name="phone" />
                  </div>

                  <textarea type="text" class="form-textarea textarea" name="message" placeholder="Сообщение"></textarea>
                  
                  <!-- CSRF-токен -->
                  <input type="hidden" name="csrf" value="<?php echo h(csrf_token()) ;?>">
                  <!-- // CSRF-токен -->

                  <div class="form-contact__button">
                    <button class="button-solid" name="submit" type="submit" value="submit">Отправить</button>
                  </div>
                </form>
              </div>
              
            </div>
      </div>
 
      
    </div>
  </section>
</main>