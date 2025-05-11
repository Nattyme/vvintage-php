<main class="inner-page">
  <section class="page-cart">
    <div class="container">
      <div class="page-cart__header">
        <div class="section-title">
          <h1 class="h1">Корзина</h1>
        </div>
       <?php include 'templates/_parts/breadcrumbs/breadcrumbs.tpl';?>
      </div>

      <div class="page-cart__cart-wrapper">

        <!-- cart table-->
        <div class="cart">
          <div class="cart__head">
            <div class="cart__grid">
              <div class="cart__grid-block">
                <h2 class="cart__heading">Товар</р>
              </div>
              <div class="cart__grid-block">
                <p class="cart__heading">Количество</p>
              </div>
              <div class="cart__grid-block">
                <p class="cart__heading">Стоимость</p>
              </div>
          
            </div>
          </div>

          <div class="cart__body">
            <?php foreach ($products as $product) : ?>
              <div class="cart__grid cart__grid--relative">
                <div class="cart__row">
                  <a href="" class="cart__delete link-above-others" aria-label="Удалить товар <?php echo $product['title'];?>">
                    <svg class="icon icon--delete">
                      <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#delete';?>"></use>
                    </svg>  
                  </a>
                
                  <div class="cart__img">
                    <img src="<?php echo HOST;?>usercontent/products/<?php echo empty($product['filename']) ? "no-photo.jpg" : $product['filename'];?>" 
                    srcset="<?php echo HOST . 'usercontent/products/' . $product['filename'];?>" 
                    alt="<?php echo $product['title'];?>">
                  </div>

                  <div class="cart__title">
                    <a href="<?php echo HOST . 'shop/1';?>" class="link-to-page">
                      <h2 class="cart__text"><?php echo $product['title']; ?></h2>
                    </a>
                  </div>
                </div>

                <div class="cart__row">
                  <div class="cart__amount">
                    <span class="cart__text">
                      <?php echo $cart[$product['id']]; ?>
                    </span>
                  </div>
                </div>
                
                <div class="cart__row">
                  <div class="cart__price">
                    <span class="cart__text"><?php echo $product['price']; ?></span>
                  </div>
                </div>

              </div>
            <?php endforeach; ?>
          </div>

          <div class="cart__bottom">
            <div class="cart__summary-wrapper">
              <div class="cart__summary">
                <div class="cart__grid">
                  <p class="cart__total-amount">
                    Количество товаров: <span><?php echo count($products);?></span>
                  </p>
                  <p class="cart__total">
                    Итого: <span><?php echo $cartTotalPrice; ?></span>
                  </p>
          
                </div>
              </div>
            </div>
        
            <div class="cart__row cart__row--end">
              <a href="<?php echo HOST;?>neworder" class="button button-primary">
                Оформить заказ
              </a>
            </div>

          </div>

        </div>
        <!--// cart table-->

      </div>

    </div>
  </section>
</main>

