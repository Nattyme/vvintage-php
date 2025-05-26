<main class="inner-page">
  <section class="page-order">
    <div class="container">
      <div class="page-order__header">
        <div class="section-title">
          <h1 class="h1">Оформление заказа</h1>
        </div>

        <?php include ROOT . 'templates/_parts/breadcrumbs/breadcrumbs.tpl';?>

      </div>

      <?php include ROOT . "templates/components/errors.tpl"; ?>
      <?php include ROOT . "templates/components/success.tpl"; ?>

         <div class="form-order__details">
            <fieldset class="form-order__block">
              <legend class="form-order__title form-order__title-wrapper form-order__title-block">
                <h3>Ваш заказ</h3>
              </legend>

              <div class="form-order__table">
                <div class="form-order__table-row form-order__table-header">
                  <p>Товар</p>
                  <p>Цена</p>
                  <p>Количество</p>
                </div>
                <?php foreach ($products as $product) : ?>
                    <div class="form-order__table-row">
                      <p><?php echo h($product['title']);?></p>
                      <p><?php echo h($product['price']);?></p>
                      <p><?php echo h($cart[$product['id']]);?></p>
                    </div>
                  <?php endforeach; ?>
                <div class="form-order__total form-order__table-row">
                  <p>Итого</p>
                  <p><?php echo  h($cartTotalPrice); ?></p>
                  <p><?php echo  h($cartCount); ?></p>
                </div>
              </div>
            </fieldset>
          </div>

      <div class="page-order__form">
        <form class="form-order" method="POST">
          <div class="form-order__user">
              <fieldset class="form-order__block">
                <legend class="form-order__title form-order__title-wrapper form-order__title-block">
                  <h3>Данные покупателя</h3>
                </legend>
                <div class="form-order__input-wrapper">
                  <div class="form-order__field">
                    <label class="form-order__label" for="name">Имя</label>
                    <input type="text" class="form-input input" placeholder="Имя" name="name" id="name">
                  </div>

                  <div class="form-order__field">
                    <label class="form-order__label" for="surname">Фамилия</label>
                    <input type="text" class="form-input input" placeholder="Фамилия" name="surname" id="surname">
                  </div>
                  
                  <div class="form-order__field">
                    <label class="form-order__label" for="email">Электронная почта</label>
                    <input type="text" class="form-input input input" placeholder="E-mail" name="email" id="email">
                  </div>

                  <div class="form-order__field">
                    <label class="form-order__label" for="phone">Телефон</label>
                    <input type="text" class="form-input input" placeholder="Телефон" name="phone" id="phone">
                  </div>
                 
                </div>
              </fieldset>
              <fieldset class="form-order__block">
                  <legend class="form-order__title form-order__title-wrapper form-order__title-block">
                    <h3>Данные по доставке</h3>
                  </legend>

                 <div class="form-order__field">
                    <label class="form-order__label" for="address"><h3>Адрес доставки</h3></label>
                    <textarea class="textarea" name="address" placeholder="Введите адрес доставки" title="Адрес доставки" id="address"></textarea>
                  </div>
               
                  <div class="form-order__field">
                    <label class="form-order__label" for="message">
                      <h3>Комментарии</h3>
                    </label>
                    <textarea type="text" class="textarea" name="message" placeholder="Введите ваш комментарий"  id="message"></textarea>
                
                  </div>
              </fieldset>
         
                  <!-- Выбор оплаты -->
              <!-- <div class="form-order__block">
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
                
              </div> -->
              <!-- // Выбор оплаты -->
          </div>
          <!-- CSRF-токен -->
          <input type="hidden" name="csrf" value="<?php echo h(csrf_token()) ;?>">
          <!-- // CSRF-токен -->

          <div class="form-order__button-wrapper">
            <a class="button button-outline" href="<?php HOST;?>cart">Вернуться в корзину </a>
            <button class="form-order__button button button-solid" type="submit" name="submit">
              Разместить заказ
            </button>
          </div>
       
        </form>
      </div>
    </div>
  </section>
</main>