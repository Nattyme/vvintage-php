<nav class="blog-nav">

  <ul class="blog-nav__list">
     <?php foreach ($navigation as $category) : ?>
      <li class="blog-nav__item">
     
        <a 
          class="blog-nav__link" 
          href="<?php echo HOST . 'blog/' . $category->slug?>"
        >
        <?php echo  h($category->title) ;?>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
  
</nav>