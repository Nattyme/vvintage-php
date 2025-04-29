<?php foreach ($catsArray as $catKey => $category) : ?>
  <li class="sub-nav__item">
    <a href="<?php echo HOST . 'shop/cat/' . $catKey; ?>" class="sub-nav__link">
      <?php echo $category['cat_title'];?>
    </a>
    <div class="sub-nav__dropdown-menu">
  
      <?php include ROOT . "templates/_parts/sub-nav/_dropdown-menu.tpl"; ?>
   
    </div>
  </li>
<?php endforeach; ?>