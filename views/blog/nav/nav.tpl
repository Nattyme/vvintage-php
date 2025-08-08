<ul class="nav-list nav-list--blog nav-list--header">
   <?php foreach ($postViewModel['mainCategories'] as $category) : ?>
    <li class="nav-list__item nav-list__item--header">
      <a 
        class="nav-list__link nav-list__link--header" 
        href="<?php echo HOST . "blog/{}"?>"
      >
        <?php echo  h($category->getTitle()) ;?>
      </a>
    </li>
  <?php endforeach; ?>
</ul>