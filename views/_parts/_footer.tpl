<footer class="footer">
	<div class="container">
    <?php if($isBlogPage) : ?>
      <div class="footer__top">
        <div class="footer__topics">
          <div class="footer__topics-header">
              <?php echo h(__('blog.cats.sub.view.all', [], 'blog'));?>
          </div>
            <ul class="topics-list">

              <?php foreach( $navigation['footer'] as $category) : ?>
                <li class="topics-list__item">
                  <a class="topics-list__link" href="#">
                    <?php echo h($category->title); ?>
                  </a>
                </li>
              <?php endforeach; ?>
             
            </ul>
          </div> 
        </div>
    <?php endif; ?>
    <div class="footer__content">
      <div class="footer__column">
        <div class="footer__logo">
        <a href="
              <?php if ($routeData->uriModule === '' || $routeData->uriModule === 'main') {
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
          <p><a href="#">Политика конфиденциальности</a></p>
          <p><a href="#">Публичная оферта</a></p>
          <p><a href="#">О предоставлении услуг</a></p>
        </div>
      </div>
    
      <div class="footer__nav">
        <?php if(!$isBlogPage) : ?>
          <ul class="nav-list">
            <?php foreach($navigation as $link) : ?>
              <li class="nav-list__item">
                <a class="nav-list__link" href="<?php echo HOST . $link['slug'];?>">
                  <?php echo h($link['title']);?>
                </a>
              </li>
            <?php endforeach; ?>
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
    <a href="#top" class="button button--backtop" id="backtop" title="Наверх">
      <svg class="icon icon--arrow">
        <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#arrow';?>"></use>
      </svg>
    </a>
    <!--// backtop button -->
	</div>

</footer>


