<a href="<?php echo HOST . 'shop/cat/' . u($category['id']);?>" class="card-small">
  <div class="card-small__img">
    <svg class="icon icon--arrow-right">
      <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#arrow-right';?>"></use>
    </svg>

    <picture>
      <!-- <source srcset="<?php echo HOST . 'static/img/cats/' . h($category['image']) . 'static/img/cats/' . h($category['image']);?>" type="image/webp" /> -->
      <source srcset="<?php echo HOST . 'static/img/cats/' . h($category['image']);?>" type="image/jpeg" />
      <img 
        src="<?php echo HOST . 'static/img/cats/' . h($category['image']);?>" 
        srcset="<?php echo HOST . 'static/img/cats/' . h($category['image']);?>" 
        alt="<?php echo h($category['title']); ?>" 
      />
    </picture>
  </div>
  <!-- price -->
  <div class="card-small__desc">
    <div class="card-small__title">
      <h4 class="h4"><?php echo h($category['title']); ?></h4>
    </div>
  </div>
  <!--// price -->
</a>