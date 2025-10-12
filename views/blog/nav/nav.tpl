<nav class="blog-nav">

  <ul class="blog-nav__list">
     <?php foreach ($viewModel['mainCategories'] as $category) : ?>
      <li class="blog-nav__item">
        <a 
          class="blog-nav__link" 
          href="<?php echo HOST . "blog/"?>"
        >
        <?php echo  h($category->title) ;?>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
  
</nav>