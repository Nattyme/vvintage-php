<main class="inner-page">
  <section class="page-cart">
    <div class="container">
      <!-- Заголовок и хлебные крошки -->
      <?php include ROOT . 'views/_parts/_inner-header.tpl'; ?>

      <div class="notifications-wrapper">
        <?php include ROOT . "views/components/success.tpl"; ?>
      </div>

      <div class="page-cart__cart-wrapper">
        <?php include ROOT . 'views/components/success.tpl'; ?>

       
        <?php 
          if (!empty($viewModel['products'])) :
            // <!-- cart table-->
            include ROOT . 'views/cart/_parts/_table.tpl';
       
          else : 
            // <!-- empty cart -->
            include ROOT . 'views/cart/_parts/_emptyCart.tpl';
          endif; 
        ?>

      </div>

    </div>
  </section>
</main>

