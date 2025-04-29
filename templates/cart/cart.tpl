<main class="inner-page">
  <section class="page-cart">
    <div class="container">
      <div class="page-cart__header">
        <div class="section-title">
          <h1 class="h1">Корзина</h1>
        </div>
        <div class="breadcrumbs">
          <a href="#!" class="breadcrumb ">Главная</a> 
          <span>&mdash;</span> 
          <a href="#!" class="breadcrumb breadcrumb--active">Корзина</a> 
        </div>
      </div>

      <div class="page-cart__cart-wrapper">

        <!-- cart table-->
        <div class="cart">
          <div class="cart__head">
            <div class="cart__grid">
              <div class="cart__grid-block">
                <p class="cart__heading">Товар</p>
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
            <div class="cart__grid cart__grid--relative">
              <div class="cart__row">
                <a href="" class="cart__delete link-above-others">
                  <svg class="icon icon--delete">
                    <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#delete';?>"></use>
                  </svg>  
                </a>
              
                <div class="cart__img">
                  <img src="<?php echo HOST . 'static/img/cart/01.jpg';?>" srcset="<?php echo HOST . 'static/img/cart/01@2x.jpg';?>" alt="Футболка">
                </div>

                <div class="cart__title">
                  <a href="<?php echo HOST . 'shop/1';?>" class="link-to-page">
                    <span class="cart__text"> Футболка USA</span>
                  </a>
                </div>
              </div>

              <div class="cart__row">
                <div class="cart__amount">
                  <span class="cart__text">1</span>
                </div>
              </div>
              
              <div class="cart__row">
                <div class="cart__price">
                  <span class="cart__text">$129</span>
                </div>
              </div>

            </div>
          </div>

          <div class="cart__bottom">
            <div class="cart__summary-wrapper">
              <div class="cart__summary">
                <div class="cart__grid">
                  <p class="cart__total-amount">
                    Количество товаров: <span>10</span>
                  </p>
                  <p class="cart__total">
                    Итого: <span>$129</span>
                  </p>
          
                </div>
              </div>
            </div>
        
            <div class="cart__row cart__row--end">
              <a href="#" class="button-primary">
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

