<ul class="tab__nav nav__list products-nav" data-control="tab-nav">
  <li class="nav__list-item">
    <button class="tab__nav-button active  products-nav__button" data-control="tab-button">Все</button>
    <div class="nav__list-item__sub-nav">
      <ul class="sub-nav">
        <?php include ROOT . 'templates/shop/sub-nav/_portfolio.tpl'; ?>
      </ul>
    </div>
  </li>

  <li class="nav__list-item">
    <button class="tab__nav-button products-nav__button" data-control="tab-button">Для женщин</button>
    <div class="nav__list-item__sub-nav">
      <ul class="sub-nav">
      <?php for ($i = 0; $i < 20; $i ++) : ?>
        <!-- card -->
        <?php include ROOT . 'templates/shop/sub-nav/_portfolio.tpl'; ?>
        <!--// card -->
      <?php endfor; ?>
      </ul>
    </div>
  </li>
  <li class="nav__list-item">
    <button class="tab__nav-button products-nav__button" data-control="tab-button">Для мужчин</button>
    <div class="nav__list-item__sub-nav">
      <ul class="sub-nav">
      <?php for ($i = 0; $i < 20; $i ++) : ?>
        <!-- card -->
        <?php include ROOT . 'templates/shop/sub-nav/_portfolio.tpl'; ?>
        <!--// card -->
      <?php endfor; ?>
     
      </ul>
    </div>
  </li>
  <li class="nav__list-item">
    <button class="tab__nav-button products-nav__button" data-control="tab-button">Для детей</button>
    <div class="nav__list-item__sub-nav">
      <ul class="sub-nav">
      <?php for ($i = 0; $i < 20; $i ++) : ?>
        <!-- card -->
        <?php include ROOT . 'templates/shop/sub-nav/_portfolio.tpl'; ?>
        <!--// card -->
      <?php endfor; ?>
      </ul>
    </div>
  </li>
  <li class="nav__list-item">
    <button class="tab__nav-button products-nav__button" data-control="tab-button">Для дома</button>
    <div class="nav__list-item__sub-nav">
      <ul class="sub-nav">
      <?php for ($i = 0; $i < 20; $i ++) : ?>
        <!-- card -->
        <?php include ROOT . 'templates/shop/sub-nav/_portfolio.tpl'; ?>
        <!--// card -->
      <?php endfor; ?>
      </ul>
    </div>
  </li>
</ul>
