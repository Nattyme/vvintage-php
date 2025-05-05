<a href="shop-single.html" class="card-small">
  <div class="card-small__img">
    <svg class="icon icon--arrow-right">
      <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#arrow-right';?>"></use>
    </svg>

    <picture>
      <source srcset="<?php echo HOST . 'static/img/cats/' . $category['image'] . '.webp 1x,' . 'static/img/cats/' . $category['image'] . '@2x.webp 2x';?>" type="image/webp" />
      <source srcset="<?php echo HOST . 'static/img/cats/' . $category['image'] . '@2x.jpg 2x';?>" type="image/jpeg" />
      <img 
        src="<?php echo HOST . 'static/img/cats/' . $category['image'] . '.jpg';?>" 
        srcset="<?php echo HOST . 'static/img/cats/' . $category['image'] . '@2x.jpg';?>" 
        alt="<?php echo $category['title']; ?>" 
      />
    </picture>
  </div>
  <!-- price -->
  <div class="card-small__desc">
    <div class="card-small__title">
      <h4 class="h4"><?php echo $category['title']; ?></h4>
    </div>
  </div>
  <!--// price -->
</a>