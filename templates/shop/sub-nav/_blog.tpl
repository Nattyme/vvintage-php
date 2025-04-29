<?php foreach ($category_post as $category) : ?>
  <li class="sub-nav__item">
    <a href="<?php echo HOST . 'blog/cat/' . $category['id']; ?>" class="sub-nav__link">
      <?php echo $category['title'];?>
    </a>
    <div class="sub-nav__dropdown-menu">
      <!-- <ul class="sub-nav-inner">
        <li class="sub-nav-inner__item">
          <a href="<?php echo HOST . 'blog/cat/' . $category['id']; ?>" class="sub-nav-inner__link">
            Бренд 1
          </a>
        </li>
        <li class="sub-nav-inner__item">
          <a href="<?php echo HOST . 'blog/cat/' . $category['id']; ?>" class="sub-nav-inner__link">
            Бренд 2
          </a>
        </li>
      </ul>  -->
    </div>
  </li>
<?php endforeach; ?>