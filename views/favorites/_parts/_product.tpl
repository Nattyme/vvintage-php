<div class="cart__grid cart__grid--relative">
  <div class="cart__row">
    <a 
      href="<?php echo HOST . 'removefromfav?id=' . u($product->id);?>" 
      class="button button-close cross-wrapper cart__delete link-above-others " 
      aria-label="Удалить товар <?php echo h($product->title);?>">
      <span class="leftright"></span><span class="rightleft"> </span>
    </a>
 
    <div class="cart__img">
      <img 
        src="<?php echo HOST;?>usercontent/products/<?php echo empty($product->image_filename) 
        ? "no-photo.jpg" : h($product->image_filename);?>" 
        srcset="<?php echo HOST . 'usercontent/products/' . h($product->image_filename);?>" 
        alt="<?php echo h($product->title);?>">
    </div>

    <div class="cart__title">
      <a href="<?php echo HOST . 'shop/' . h($product->id);?>" class="link-to-page">
        <h2 class="cart__text"><?php echo h($product->title);?></h2>
      </a>
    </div>
  </div>
  
  <div class="cart__row">
    <div class="cart__price">
      <span class="cart__text">
        <?php echo h($product->price); ?>&nbsp;&euro;
      </span>
    </div>
  </div>

</div>