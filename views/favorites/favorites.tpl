<main class="inner-page">
  <section class="page-cart">
    <div class="container">
      <div class="page-cart__header">
        <div class="section-title">
          <h1 class="h1">Избранное</h1>
        </div>
       <?php include 'views/_parts/breadcrumbs/breadcrumbs.tpl';?>
      </div>

      <div class="page-cart__cart-wrapper">
        <?php include ROOT . 'views/components/success.tpl'; ?>

        <?php if (!empty($products)) : ?>
          <!-- cart table-->
          <div class="cart">
            <div class="cart__head">
              <div class="cart__grid">
                <div class="cart__grid-block">
                  <h2 class="cart__heading">Товар</р>
                </div>
                <div class="cart__grid-block">
                  <p class="cart__heading">Описание</p>
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
                    <a 
                      href="<?php echo HOST . 'removefromfav?id=' . u($product['id']);?>" 
                      class="button button-close cross-wrapper cart__delete link-above-others " 
                      aria-label="Удалить товар <?php echo h($product['title']);?>">
                      <span class="leftright"></span><span class="rightleft"> </span>
                    </a>
                  
                    <div class="cart__img">
                      <img src="<?php echo HOST;?>usercontent/products/<?php echo empty($product['filename']) ? "no-photo.jpg" : h($product['filename']);?>" 
                      srcset="<?php echo HOST . 'usercontent/products/' . h($product['filename']);?>" 
                      alt="<?php echo h($product['title']);?>">
                    </div>

                    <div class="cart__title">
                      <a href="<?php echo HOST . 'shop/' . h($product['id']);?>" class="link-to-page">
                        <h2 class="cart__text"><?php echo h($product['title']); ?></h2>
                      </a>
                    </div>
                  </div>

                  <div class="cart__row">
                    <div class="cart__amount">
                      <span class="cart__text">
                         Описание
                      </span>
                    </div>
                  </div>
                  
                  <div class="cart__row">
                    <div class="cart__price">
                      <span class="cart__text"><?php echo h($product['price']); ?>&nbsp;&euro;</span>
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
                      Количество товаров: <span class="text-bold"><?php echo count($products);?></span>
                    </p>
                    <!-- <p class="cart__total">
                      Итого: <span class="text-bold"><?php echo h($totalPrice); ?>&nbsp;&euro;</span>
                    </p> -->
            
                  </div>
                </div>
              </div>
          
              <!-- <div class="cart__row cart__row--end">
                <a href="<?php echo HOST;?>neworder" class="button button--primary button--l">
                  Оформить заказ
                </a>
              </div> -->

            </div>

          </div>
          <!--// cart table-->
        <?php else : ?>
          <div class="page-cart__empty">
            <h1 class="page-cart__title page-cart__title-wrapper">Список избранного пуст</h1>
            <a href="<?php echo HOST;?>shop" class="button button--primary button--m">Добавить товары</a>
          </div>
        <?php endif; ?>

      </div>

    </div>
  </section>
</main>

