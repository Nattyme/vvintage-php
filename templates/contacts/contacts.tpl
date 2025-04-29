<main class="inner-page">
  <section class="contacts">
    <div class="container">
      <div class="contacts__header">
        <div class="section-title">
          <h1 class="h1">Контакты</h1>
        </div>
        <div class="breadcrumbs">
          <p><a href="<?php echo HOST . 'main';?>">Главная</a> <span>&#8212;</span> <span class="breadcrumb breadcrumb--active">Контакты</span></p>
        </div>
      </div>
      <div class="contacts__map-wrapper">
        <div class="contacts__map" id="map" style="width: 100%; height: 476px"></div>
      </div>
      <div class="contacts__widget">
        <ul class="contacts__list">
          <li class="contacts__item">
            <p>Телефон</p>
            <a href="tel:74958235412" class="contacts__link">+7&#160;495&#160;823-54-12</a>
          </li>
          <li class="contacts__item">
            <p>E-mail</p>
            <a href="mailto:info@sitename.com" class="contacts__link">info@sitename.com</a>
          </li>
          <li class="contacts__item">
            <p>Адрес</p>
            <p>г. Москва, 3-я улица Строителей, 25</p>
          </li>
        </ul>
      </div>
      
      <div class="contacts__widget">
        <?php include ROOT . "templates/components/errors.tpl"; ?>
        <div class="contacts__form">
          <form action="<?php echo HOST . 'contacts';?>" class="form-contact" method="POST">
            <h3 class="form-contact__title">Напишите нам</h3>
            <div class="form-input-wrapper">
              <input type="text" class="form-input" placeholder="Имя" name="name" />
              <input type="text" class="form-input" placeholder="E-mail" name="email" />
              <input type="text" class="form-input" placeholder="Телефон" name="phone" />
            </div>

            <textarea type="text" class="form-textarea" name="message" placeholder="Сообщение"></textarea>
            <div class="form-contact__button">
              <button class="button-solid" name="submit" type="submit" value="submit">Отправить</button>
            </div>
          </form>
        </div>
        <?php include ROOT . "templates/components/success.tpl"; ?>
      </div>
    
      
    </div>
  </section>
</main>