<nav class="menu-nav">

  <ul class="menu-nav__list menu-nav__list--header">
    <?php foreach($navigation as $link) : ?>
    <li class="menu-nav__item">
      <a class="menu-nav__link" href="<?php echo HOST . $link['slug'];?>">
        <?php echo h($link['title']);?>
      </a>
    </li>
    <?php endforeach; ?>
  </ul>
</nav>
    <!-- <li class="menu-nav__item">
      <a class="menu-nav__link" href="">Главная</a>
    </li> -->