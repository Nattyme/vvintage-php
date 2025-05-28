<footer class="footer">
	<div class="container">
    <?php if($isBlogPage) : ?>
      <div class="footer__top">
        <div class="footer__topics">
          <div class="footer__topics__title">Заголовок тем</div>
            <ul class="footer__topics__list">
              <li>
                <a href="">Тег</a>
              </li>
              <li>
                <a href="">Тег</a>
              </li>
              <li>
                <a href="">Тег</a>
              </li>
              <li>
                <a href="">Тег</a>
              </li>
              <li>
                <a href="">Тег</a>
              </li>
            </ul>
          </div> 
        </div>
    <?php endif; ?>
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
          <p><a href="<?php HOST;?>">О предоставлении услуг</a></p>
        </div>
      </div>
      
      <div class="footer__nav">
        <?php if(!$isBlogPage) : ?>
          <ul class="nav-list">
            <li class="nav-list__item">
            <a class="nav-list__link" href="<?php echo HOST;?>">Главная</a>
            </li>
            <li class="nav-list__item">
            <a class="nav-list__link nav-list__inner-nav" href="<?php echo HOST . 'shop';?>">Магазин</a>
            </li>
            <li class="nav-list__item">
            <a class="nav-list__link" href="<?php echo HOST . 'about';?>">О нас</a>
            </li>
            <li class="nav-list__item">
            <a class="nav-list__link" href="<?php echo HOST . 'contact';?>">Контакты</a>
            </li>
          </ul>
        <?php endif; ?>
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
        <!-- <ul class="payment-list">
          <li><img src="<?php echo HOST . 'static/img/payment/visa-mastercard.png';?>" srcset="<?php echo HOST . 'static/img/payment/visa-mastercard@2x.png';?>" alt=""></li>
        </ul> -->
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


