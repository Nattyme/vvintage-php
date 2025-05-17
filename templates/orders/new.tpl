<main class="inner-page">
  <section class="page-order">
    <div class="container">
      <div class="page-order__header">
        <div class="section-title">
          <h1 class="h1">Оформление заказа</h1>
        </div>

        <?php @@include ROOT . 'templates/_parts/breadcrumbs/breadcrumbs.tpl';?>

      </div>
      <div class="page-order__form">
        <form class="form-order" method="POST">
          <div class="form-order__user">
              <div class="form-order__block">
                <div class="form-order__title">
                  <h3>Данные покупателя</h3>
                </div>
                <div class="form-order__input-wrapper">
                  <input type="text" class="form-input" placeholder="Имя" name="name">
                  <input type="text" class="form-input" placeholder="E-mail" name="email">
                  <input type="text" class="form-input" placeholder="Телефон" name="phone">
                </div>
              </div>
              <div class="form-order__block">
                <div class="form-order__title">
                  <h3>Адрес получателя</h3>
                </div>
                <div class="form-order__input-wrapper">
                  <input type="text" class="form-input" placeholder="Имя" name="name">
                  <input type="text" class="form-input" placeholder="E-mail" name="email">
                  <input type="text" class="form-input" placeholder="Телефон" name="phone">
                  <input type="text" class="form-input" placeholder="Телефон" name="phone">
                  <input type="text" class="form-input" placeholder="Телефон" name="phone">
                </div>
              </div>
              <div class="form-order__block">
                <div class="form-order__title">
                  <h3>Комментарии</h3>
                </div>
                <div class="form-input-wrapper">
                  <textarea type="text" class="form-textarea" name="message">Сообщение</textarea>
                </div>
              </div>
          </div>
          <div class="form-order__details">
            <div class="form-order__block">
              <div class="form-order__title">
                <h3>Ваш заказ</h3>
              </div>

              <div class="form-order__table">
                <div class="form-order__table-row">
                  <p>Товар</p>
                  <p>Цена</p>
                  <p>Количество</p>
                </div>
             <?php foreach ($products as $product) : ?>
                <div class="form-order__table-row">
                  <p><?php echo $product['title'];?></p>
                  <p><?php echo $product['price'];?></p>
                  <p><?php echo $cart[$product['id']];?></p>
                </div>
              <?php endforeach; ?>
                <div class="form-order__total form-order__total--button-fake form-order__table-row">
                    <p>Итого</p>
                    <p><?php echo  $cartTotalPrice; ?></p>
                </div>
              </div>
              
              <!-- Выбор оплаты -->
              <div class="form-order__block">
                <div class="form-order__title">
                  <h3>Способы оплаты</h3>
                </div>

                <div class="form-order__row">
                  <label class="radio-button">
                    <input class="radio-button-real " name="select-payment" type="radio">
                    <span class="radio-button-custom radio-button-custom--before radio-button-custom--payment"></span>
                    <div class="form-order__img-wrapper">
                      <img src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#mir';?>" alt="mir">
                    </div>
                  </label>

                  <label class="radio-button">
                    <input class="radio-button-real" name="select-payment" type="radio">
                    <span class="radio-button-custom radio-button-custom--before radio-button-custom--payment"></span>
                    <div class="form-order__img-wrapper">
                      <img src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#visa';?>" alt="visa">
                    </div>
                  </label>
              
                  <label class="radio-button">
                    <input class="radio-button-real" name="select-payment" type="radio">
                    <span class="radio-button-custom radio-button-custom--before radio-button-custom--payment"></span>
                    <div class="form-order__img-wrapper">
                      <img src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#paypal';?>" alt="paypal">
                    </div>
                
                  </label>

                  <label class="radio-button">
                    <input class="radio-button-real" name="select-payment" type="radio">
                    <span class="radio-button-custom radio-button-custom--before radio-button-custom--payment"></span>
                    <div class="form-order__img-wrapper">
                      <img src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#mastercard';?>" alt="mastercard">
                    </div>
                  
                  </label>
                </div>
                
              </div>
              <!-- // Выбор оплаты -->

              <button class="form-order__button button button-solid" type="submit" name="submit">
                Разместить заказ
              </button>
              <a class="button button-outline" href="<?php HOST;?>cart">Вернуться в корзину </a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
</main>

   <?php print_r($_SESSION);
                die();
                ?>