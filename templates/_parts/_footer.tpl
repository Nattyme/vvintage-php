<footer class="footer">
	<div class="container">
    <div class="footer__content">
      <div class="footer__column">
        <div class="footer__logo">
        <a href="
              <?php if ($uriModule === '' || $uriModule === 'main') {
                      echo '#';
                    } else {
                      echo 'main';
                    } 
              ?>
            " class="logo">
						VVintage
          </a>
        </div>
        <div class="footer__copyright">
          <p>&copy; Все права защищены</p>
          <p><a href="">Политика конфиденциальности</a></p>
          <p><a href="">Публичная оферта</a></p>
          <p><a href="./policy.html">О предоставлении услуг</a></p>
        </div>
      </div>
      
      <div class="footer__nav">
        <ul class="nav-list">
          <li class="nav-list__item">
           <a class="nav-list__link" href="#!">Главная</a>
          </li>
          <li class="nav-list__item">
           <a class="nav-list__link nav-list__inner-nav" href="#!">Магазин</a>
           <div class="inner-nav-wrapper">
            <ul class="inner-nav__list">
              <li class="inner-nav__item">
                <a href="#!" class="inner-nav__link">Пальто</a>
              </li>
              <li class="inner-nav__item">
                <a href="#!" class="inner-nav__link">Свитшоты</a>
              </li>
              <li class="inner-nav__item">
                <a href="#!" class="inner-nav__link">Кардиганы</a>
              </li>
              <li class="inner-nav__item">
                <a href="#!" class="inner-nav__link">Толстовки</a>
              </li>
             </ul>
           </div>
          
          </li>
          <li class="nav-list__item">
           <a class="nav-list__link" href="#!">О нас</a>
          </li>
          <li class="nav-list__item">
           <a class="nav-list__link" href="#!">Контакты</a>
          </li>
        </ul>
      </div>
       
      <div class="footer__column">
        <div class="footer__contact">
          <a href="tel:330606459426">+33-0606459426</a>
          <a href="mailto:vvintage.store@yandex.com">vvintage.store@yandex.com</a>
        </div>
        <ul class="social-list">
          <li><a href="#">
            <svg class="icon icon--instagram">
              <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#instagram';?>"></use>
            </svg>
          </a></li>
          <li><a href="#">
            <svg class="icon icon--facebook">
              <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#facebook';?>"></use>
            </svg>
          </a></li>
          <li><a href="#">
            <svg class="icon icon--twitter">
              <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#twitter';?>"></use>
            </svg>
          </a></li>
        </ul>
        <ul class="payment-list">
          <li><img src="<?php echo HOST . 'static/img/payment/visa-mastercard.png';?>" srcset="<?php echo HOST . 'static/img/payment/visa-mastercard@2x.png';?>" alt=""></li>
        </ul>
      </div>
    </div>
	</div>
</footer>


