<main class="inner-page">
  <section class="page-order">
    <div class="container">
      <div class="page-order__header">
        <div class="section-title">
          <h1 class="h1">Оформление заказа</h1>
        </div>

        <?php @@include ROOT . 'templates/_parts/breadcrumbs/breadcrumbs.tpl';?>

      </div>

      <?php include ROOT . "templates/components/errors.tpl"; ?>
      <?php include ROOT . "templates/components/success.tpl"; ?>

         <div class="form-order__details">
            <fieldset class="form-order__block">
              <legend class="form-order__title form-order__title-wrapper form-order__title-block">
                <h3>Ваш заказ</h3>
              </legend>

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
            </fieldset>
          </div>

      <div class="page-order__form">
        <form class="form-order" method="POST">
          <div class="form-order__user">
              <div class="form-order__block">
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
              </div>
              <div class="form-order__block">
                 <div class="form-order__field">
                    <legend class="form-order__title form-order__title-wrapper form-order__title-block">
                      <h3>Адрес доставки</h3>
                    </legend>
                    <textarea class="textarea" name="address" placeholder="Введите адрес доставки" title="Адрес доставки">
                    </textarea>
                  </div>
               
                  <div class="form-order__field">
                    <legend class="form-order__title form-order__title-wrapper form-order__title-block">
                      <h3>Комментарии</h3>
                    </legend>
                    <div class="form-input-wrapper">
                      <textarea type="text" class="form-textarea" name="message">Сообщение</textarea>
                    </div>
                  </div>
              </div>
         
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
          <div class="form-order__button-wrappers">
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

   <?php print_r($_SESSION);
                die();
                ?>