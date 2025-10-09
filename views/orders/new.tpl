<main class="inner-page">

  <section class="page-order">
    <div class="container">
      <div class="page-order__header">
        <div class="section-title">
          <h1 class="h1">Оформление заказа</h1>
        </div>

        <?php include ROOT . 'views/_parts/breadcrumbs/breadcrumbs.tpl';?>

      </div>

      <?php include ROOT . "views/components/errors.tpl"; ?>
      <?php include ROOT . "views/components/success.tpl"; ?>

         <div class="form-order__details">
            <fieldset class="form-order__block">
              <legend class="form-order__title form-order__title-wrapper form-order__title-block">
                <h3>
                  <?php echo h(__('order.title', [], 'order'));?>
                </h3>
              </legend>

              <div class="form-order__table">
                <div class="form-order__table-row form-order__table-header">
                  <p><?php echo h(__('order.product', [], 'order'));?></p>
                  <p><?php echo h(__('order.price', [], 'order'));?></p>
                  <p><?php echo h(__('order.quantity', [], 'order'));?></p>
                </div>
                <?php foreach ($products as $product) : ?>
                    <div class="form-order__table-row">
                      <p><?php echo h($product->title);?></p>
                      <p><?php echo h($product->title);?></p>
                      <p><?php echo h($cartModel->getQuantity($product->id)); ?></p>
                    </div>
                  <?php endforeach; ?>
                <div class="form-order__total form-order__table-row">
                  <p><?php echo h(__('order.total', [], 'order'));?></p>
                  <p><?php echo h($totalPrice); ?></p>
                  <p><?php echo h(count($products));?></p>
                </div>
              </div>
            </fieldset>
          </div>

      <div class="page-order__form">
        <form class="form-order" method="POST">
          <div class="form-order__user">
              <fieldset class="form-order__block">
                <legend class="form-order__title form-order__title-wrapper form-order__title-block">
                  <h3>
                    <?php echo h(__('order.customer_data', [], 'order'));?>
                  </h3>
                </legend>
                <div class="form-order__input-wrapper">
                  <div class="form-order__field">
                    <label class="form-order__label" for="name">
                      <?php echo h(__('order.first_name', [], 'order'));?>
                    </label>
                    <input 
                      type="text" 
                      class="form-input input" 
                      placeholder="<?php echo h(__('order.first_name.placeholder', [], 'order'));?>" 
                      name="name" 
                      id="name"
                      value = "<?php  echo isset($user) && !empty($user->getName()) ? $user->getName() : '';?>"
                    >
                  </div>

                  <div class="form-order__field">
                    <label class="form-order__label" for="surname">
                      <?php echo h(__('order.last_name', [], 'order'));?>
                    </label>
                    <input 
                      type="text" 
                      class="form-input input" 
                      placeholder="<?php echo h(__('order.last_name.placeholder', [], 'order'));?>" 
                      name="surname" 
                      id="surname"
                      value="<?php  echo isset($user) && !empty($user->getSurname()) ? $user->getSurname() : '';?>"
                    >
                  </div>
                  
                  <div class="form-order__field">
                    <label class="form-order__label" for="email">
                      <?php echo h(__('order.email', [], 'order'));?>
                    </label>
                    <input 
                      type="text" 
                      class="form-input input input" 
                      placeholder="<?php echo h(__('order.email.placeholder', [], 'order'));?>" 
                      name="email" 
                      id="email"
                      value="<?php  echo isset($user) && !empty($user->getEmail()) ? $user->getEmail() : '';?>"
                    >
                  </div>

                  <div class="form-order__field">
                    <label class="form-order__label" for="phone">
                      <?php echo h(__('order.phone', [], 'order'));?>
                    </label>
                    <input 
                      type="text" 
                      class="form-input input" 
                      placeholder="<?php echo h(__('order.phone.placeholder', [], 'order'));?>" 
                      name="phone" 
                      id="phone"
                      value="<?php  echo isset($user) && !empty($user->getPhone()) ? $user->getPhone() : '';?>"
                    >
                  </div>
                 
                </div>
              </fieldset>
              <fieldset class="form-order__block">
                  <legend class="form-order__title form-order__title-wrapper form-order__title-block">
                    <h3>
                      <?php echo h(__('order.shipping_data', [], 'order'));?>
                    </h3>
                  </legend>

                 <div class="form-order__field">
                    <label class="form-order__label" for="address"><h3>
                      <?php echo h(__('order.address', [], 'order'));?>
                    </h3></label>
                    <textarea class="textarea" name="address" placeholder="<?php echo h(__('order.address.placeholder', [], 'order'));?>" title="<?php echo h(__('order.address', [], 'order'));?>" id="address"></textarea>
                  </div>
               
                  <div class="form-order__field">
                    <label class="form-order__label" for="message">
                      <h3><?php echo h(__('order.comment', [], 'order'));?></h3>
                    </label>
                    <textarea type="text" class="textarea" name="message" placeholder="<?php echo h(__('order.comment.placeholder', [], 'order'));?>"  id="message"></textarea>
                
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
            <a class="button button--outline button--l" href="<?php HOST;?>cart">
              <?php echo h(__('button.cancel', [], 'buttons'));?>
            </a>
            <button class="button button--primary button--l" type="submit" name="submit">
               <?php echo h(__('order.place_order', [], 'order'));?>
            </button>
          </div>
       
        </form>
      </div>
    </div>
  </section>
</main>