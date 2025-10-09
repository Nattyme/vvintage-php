<main class="inner-page delivery">
  <div class="container">

     
  <!-- Заголовок и хлебные крошки -->
  <header class="delivery__header">
    <div class="delivery__header__title">
      <h1 class="h1">
        <?php echo h($pageTitle);?>
      </h1>
    </div>
    <?php include ROOT . 'views/_parts/breadcrumbs/breadcrumbs.tpl'; ?>

  </header>
    



    <section class="delivery__schema">
      <div class="delivery__title">
        <h3 class="h3">Оформление заказа</h3>
      </div>
      <ul class="schema">
        <li class="schema__item">
          <div class="schema__icon">
            <svg class="icon icon--shopping_bag_speed">
              <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#shopping_bag_speed';?>"></use>
            </svg>
          </div>
          <div class="schema__desc">

            <p>Оформите заказ на сайте. Доступно после <a class="link">регистрации</a></p>
             <p>Администратор проверит наличие товара и рассчитает итоговую стоимость. </p>
          </div>
        </li>
        <li class="schema__item">
          <div class="schema__icon">
            <svg class="icon icon--order_approve">
              <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#order_approve';?>"></use>
            </svg>
          </div>
          <div class="schema__desc">

            <p>Данные по оплате будут направлены на email</p>
            <p>Оплатить заказ нужно в течении 15 мин с момента подтверждения.</p>
          </div>
        </li>
        <li class="schema__item">
          <div class="schema__icon">
            <svg class="icon icon--credit_card_clock">
              <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#credit_card_clock';?>"></use>
            </svg>
          </div>
          <div class="schema__desc">

            <p>После получения оплаты выкупаем товар у поставщика.</p>
            <p>Товар поступает на склад в течение недели. </p>
          </div>
      
          <a class="schema__link link" href="#!">способы оплаты</a>

        
        </li>
        <li class="schema__item">
          <div class="schema__icon">

            <svg class="icon icon--delivery_speed">
              <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#delivery_speed';?>"></use>
            </svg>
          </div>
          <div class="schema__desc">

            <p>После проверки он отправляется покупателю государственной почтой вашей страны. В графе заказа в профиле появится трек-номер</p>
          </div>
      
          <a class="schema__link link" href="#!">тарифы</a>
      
        </li>
      </ul>
    </section>
    
    <!-- <div class="delivery__content">
    
        <ul class="delivery__text">
          <li>
            <svg class="icon icon--payment">
              <use href="./img/svgsprite/sprite.symbol.svg#payment"></use>
            </svg>
            <div> Оплачивается из расчета 15 евро за 1 кг.</div>
          </li>
          <li>
            <svg class="icon icon--note">
              <use href="./img/svgsprite/sprite.symbol.svg#note"></use>
            </svg>
            <div>Итоговая стоимость рассчитывается оператором при выставлении счета.</div>
          </li>
          <li>
            <svg class="icon icon--plane">
              <use href="./img/svgsprite/sprite.symbol.svg#plane"></use>
            </svg>
            <div>Доставка по всему миру.</div>
          
          </li>
          <li>
            <svg class="icon icon--check">
              <use href="./img/svgsprite/sprite.symbol.svg#check"></use>
            </svg>
            <div>Стоимость отправляемого товара может быть задекларирована в соответствии с пожеланиями покупателя.</div>
          
          </li>
        </ul>

        <div class="delivery__img">
          <img src="./../../img//about-page/happy-postman_wide.jpg" srcset="happy-postman_wide@2x" alt="happy-postman">
        </div>
        
    </div> -->


    <section class="delivery__tip">
      <div class="tip-list">
        <div class="tip-item">
          <p>Расчет производится в рублях, евро и долларах по реальному курсу на день выставления счета</p>
          <p>Посмотреть трек номер и статус отправки можно в вашем <a href="#!" class="link">профиле.</a></p>
        </div>
        <div class="sub-nav__line-separator"></div>
        <div class="tip-item">
            <p>Есть вопросы? Ищите конкретный товар?</p>
            <a class="button button--s button--outline">Напишите нам</a>
        </div>
      </div>
    
    </section>

    
  <!-- <div class="delivery__shipment">
    
      <ul class="delivery__text">
        <li>
          <svg class="icon icon--payment">
            <use href="./img/svgsprite/sprite.symbol.svg#payment"></use>
          </svg>
          <div> Оплачивается из расчета 15 евро за 1 кг.</div>
        </li>
        <li>
          <svg class="icon icon--note">
            <use href="./img/svgsprite/sprite.symbol.svg#note"></use>
          </svg>
          <div>Итоговая стоимость рассчитывается оператором при выставлении счета.</div>
        </li>
        <li>
          <svg class="icon icon--plane">
            <use href="./img/svgsprite/sprite.symbol.svg#plane"></use>
          </svg>
          <div>Доставка по всему миру.</div>
        
        </li>
        <li>
          <svg class="icon icon--check">
            <use href="./img/svgsprite/sprite.symbol.svg#check"></use>
          </svg>
          <div>Стоимость отправляемого товара может быть задекларирована в соответствии с пожеланиями покупателя.</div>
        
        </li>
      </ul>

      <div class="delivery__img">
        <img src="./../../img//about-page/happy-postman_wide.jpg" srcset="happy-postman_wide@2x" alt="happy-postman">
      </div>
      
  </div> -->


  <section class="prices">
    <div class="delivery__title">
      <h3 class=" h3">Тарифы</h3>
    </div>

    <div class="prices__cards" id="prices">
      <div class="cards-row " >
        <div class="price-card accordion__item">
          <div class="price-card__body">
            <div class="price-card__header">
              <div class="price-card__title price-card__title--with-line">
                <h2 class="price-card__title">Россия</h2>
              </div>
              <p>ОТ <span class="text-bold text-accent">35 €</span></p>
            </div>

            <div class="price-card__img">
                <img src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#kremlin';?>" alt="logo-japan-post">
            </div>

             <button class="button button--primary button--s accordion__btn">Подробнее</button>
        
            <div class="price-card__table accordion__content">
            
                <table class="price-card__table">
                  <tr class="text-bold">
                    <td>до 1 кг</td>
                    <td>35 €</td>
                  </tr>
                  <tr>
                    <td>1 кг</td>
                    <td>37 €</td>
                  </tr>
                  <tr>
                    <td>2 кг</td>
                    <td>44 €</td>
                  </tr>
                  <tr>
                    <td>3 кг</td>
                    <td>48 €</td>
                  </tr>
                  <tr class="text-bold">
                    <td>от 4 до 5 кг</td>
                    <td>50 €</td>
                  </tr>
                </table>
  
            </div>
          </div>
      
    
        </div>
        <div class="price-card accordion__item">
          <div class="price-card__body">
            <div class="price-card__header">
              <div class="price-card__title price-card__title--with-line accordion__btn">
                <h2 class="price-card__title">МИР</h2>
              </div>
          
              <p>ОТ <span class="text-bold text-accent">37 €</span></p>
            </div>
       

            <div class="price-card__img">
              <img src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#global';?>" alt="logo-japan-post">
            </div>

            <button class="button button--primary button--s accordion__btn">Подробнее</button>
        
            <div class="price-card__table accordion__content">
                  <table class="price-card__table">
                  <tr class="text-bold">
                    <td>до 1 кг</td>
                    <td>37 €</td>
                  </tr>
                  <tr>
                    <td>1 кг</td>
                    <td>44 €</td>
                  </tr>
                  <tr>
                    <td>2 кг</td>
                    <td>48 €</td>
                  </tr>
                  <tr>
                    <td>3 кг</td>
                    <td>50 €</td>
                  </tr>
                  <tr class="text-bold">
                    <td>от 4 до 5 кг</td>
                    <td>54 €</td>
                  </tr>
                </table>
           


            </div>
          </div>
        </div>
      </div>
    </div>

  </section>

  

    
  <section class="post-logos">
    <div class="delivery__title">
      <p class="h3">Доставка заказов государственными почтовыми службами:</p>
    </div>
      <ul class="logos">
        <li class="logos__item">
          <a href="https://www.laposte.fr/" class="logos__link">
            <img src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#logo-la-poste-post';?>" alt="logo-la-poste-post">
          </a>
        </li>
        <li class="logos__item">
          <a href="https://www.japanpost.jp/" class="logos__link">
            <img src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#logo-japan-post';?>" alt="logo-japan-post">
          </a>
        </li>
        <li class="logos__item">
          <a href="http://www.chinapost.com.cn/" class="logos__link">
            <img src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#logo-china-post';?>" alt="logo-china-post">
          </a>
        </li>
        <li class="logos__item">
          <a href="#" class="logos__link">
            <img src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#logo-russian-post';?>" alt="logo-russian-post">
          </a>
        </li>
        <li class="logos__item">
          <a href="#" class="logos__link">
              <img src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#logo-correos-post';?>" alt="logo-correos-post">
          </a>
        </li>
        <li class="logos__item">
          <a href="#" class="logos__link">
            <img src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#logo-deutsche-post'?>" alt="logo-deutsche-post">
          </a>
        </li>
        <li class="logos__item">
          <a href="#" class="logos__link">
              <img src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#logo-royal-post';?>" alt="logo-royal-post">
          </a>
        </li>


      </ul>
  </section>



  <section class="terms">
    <div class="container">
          <div class="delivery__title">
            <h3 class="h3">Гарантии и условия поставки </h3>
          </div>
          <ul>
            <li>Оператор выкупает товар сразу же после поступления оплаты.</li>
            <li>Если к моменту перевода средств товар уже продан -  возвращаем оплату. Удержается только комиссия по переводу через системы.</li>
            <li>Все претензии должны направляться в письменной форме.</li>
            <li>В связи со сложной международной ситуацией и сложной работой почты, мы не принимаем возвраты товара.</li>
            <li>Мы стараемся выложить как можно больше фотографий, чтобы покупатель имел четкое представление о том, что он приобретает.</li>
            <li>Мы не несем ответственности за работу почты России.</li>
            <li>По желанию отправка может быть застрахована</li>
          </ul>

    </div>
  </section>

  <section class="payment">
    <div class="container">
      <div class="delivery__title">
        <h3 class="h3">Способы оплаты</h3>
      </div>

      <ul>
        <li>Оплата принимается разными способами. Через международные средства оплаты, такие как : Paypal, дебетовые  карты, денежные переводы, а также через отправку электронных платежей таких как системы переводов и криптовалюта. </li>
        <li>Все цены указаны в евро. Курс евро зависит от выбранного способа оплаты.</li>
        <li>Расчет производится в рублях, евро и долларах по реальному курсу на день выставления счета</li>
      </ul>

      <ul class="payment-logos">
        <li class="payment-logos__item">
          <img src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#logo-pay-paypal';?>" alt="paypal-logo">
        </li>
        <li class="payment-logos__item">
            <img src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#logo-pay-mastercard';?>" alt="mastercard-logo">
        </li>
        <li class="payment-logos__item">
          <img src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#logo-pay-bitcoin';?>" alt="bitcoin-logo">
        </li>
        <li class="payment-logos__item">
          <img src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#logo-pay-visa';?>" alt="visa-logo">
        </li>
        <li class="payment-logos__item">
            <img src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#logo-pay-mir';?>" alt="mir-logo">
        </li>
    
      </ul>
    </div>
  </section>


  </div>
</main>
