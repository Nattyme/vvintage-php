<main class="inner-page">
  <section class="page-cart">
    <div class="container">
      <div class="page-cart__header">
        <div class="section-title">
          <h1 class="h1">Корзина</h1>
        </div>
       <?php include 'views/_parts/breadcrumbs/breadcrumbs.tpl';?>
      </div>

      <div class="page-cart__cart-wrapper">
        <?php include ROOT . 'views/components/success.tpl'; ?>

       
        <?php 
          if (!empty($products)) : 
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

