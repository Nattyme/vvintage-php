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
    <!-- backtop button -->
    <a href="#top" class="backtop-btn" id="backtop" style="opacity: 1;" title="Наверх">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"> 
        <path d="M214.6 41.4c-12.5-12.5-32.8-12.5-45.3 0l-160 160c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 141.2V448c0 17.7 14.3 32 32 32s32-14.3 32-32V141.2L329.4 246.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-160-160z"/>
      </svg>
    </a>
    <!--// backtop button -->
	</div>

</footer>


