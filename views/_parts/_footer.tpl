<footer class="footer">
	<div class="container">
    <?php if($isBlogPage) : ?>
      <?php include ROOT . 'views/_parts/_parts-footer/footer-top-blog.tpl';?>
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
          <p>&copy;  <?php echo h(__('footer.copyright', [], 'footer'));?></p>
          <p><a href="#"><?php echo h(__('footer.privacy_policy', [], 'footer'));?></a></p>
          <p><a href="#"><?php echo h(__('footer.public_offer', [], 'footer'));?></a></p>
          <p><a href="#"><?php echo h(__('footer.service_provision', [], 'footer'));?></a></p>
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


