<div class="cart__grid cart__grid--relative">
  <div class="cart__row">
    <a href="<?php echo HOST . 'removefromcart?id=' . u($product->getId());?>" class="button button-close cross-wrapper cart__delete link-above-others " 
      aria-label="Удалить товар <?php echo h($product->getTitle());?>">
      <span class="leftright"></span><span class="rightleft"> </span>
    </a>
  
    <div class="cart__img">
      <img src="<?php echo HOST;?>usercontent/products/<?php echo empty($mainImage->getFilename()) ? "no-photo.jpg" : h($mainImage->getFilename());?>" 
      srcset="<?php echo HOST . 'usercontent/products/' . h($mainImage->getFilename());?>" 
      alt="<?php echo h($product->getTitle());?>">
    </div>

    <div class="cart__title">
      <a href="<?php echo HOST . 'shop/' . h($product->getId());?>" class="link-to-page">
        <h2 class="cart__text"><?php echo h($product->getTitle()); ?></h2>
      </a>
    </div>
  </div>

  <div class="cart__row">
    <div class="cart__amount">
      <span class="cart__text">
        <?php echo h($cartModel->getQuantity($product->getId())); ?>
      </span>
    </div>
  </div>
  
  <div class="cart__row">
    <div class="cart__price">
      <span class="cart__text"><?php echo h($product->getPrice()); ?>&nbsp;&euro;</span>
    </div>
  </div>

</div>