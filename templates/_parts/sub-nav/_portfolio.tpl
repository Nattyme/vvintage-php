<?php foreach ($category_project as $category) : ?>
  <li class="sub-nav__item">
    <a href="<?php echo HOST . 'portfolio/cat/' . $category['id']; ?>" class="sub-nav__link">
      <?php echo $category['title'];?>
    </a>
  </li>
<?php endforeach; ?>