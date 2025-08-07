<ul class="nav-list nav-list--blog nav-list--header">
 
  <?php foreach ($postViewModel['mainCategories'] as $category) : ?>
    <li class="nav-list__item nav-list__item--header">
      <a class="nav-list__link nav-list__link--header" href="">
        <?php echo  $category->getTitle();?>
      </a>
    </li>
  <?php endforeach; ?>

  <!-- <li class="nav-list__item nav-list__item--header">
    <a class="nav-list__link nav-list__link--header" href="">Бижутерия</a>
  </li>
  <li class="nav-list__item nav-list__item--header">
    <a class="nav-list__link nav-list__link--header" href="">История бренда</a>
  </li>
  <li class="nav-list__item nav-list__item--header">
    <a class="nav-list__link nav-list__link--header" href="">О Франции</a>
  </li> -->
</ul>