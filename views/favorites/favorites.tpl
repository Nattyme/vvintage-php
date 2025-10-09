<main class="inner-page">
  <section class="page-cart">
    <div class="container">
      <!-- Заголовок и хлебные крошки -->
      <?php include ROOT . 'views/_parts/_inner-header.tpl'; ?>
      
      <div class="page-cart__cart-wrapper">
        <?php include ROOT . 'views/components/success.tpl'; ?>

        <?php if (!empty($viewModel['products'])) : ?>
          <!-- cart table-->
          <?php include 'views/favorites/_parts/_table.tpl';?>
          <!--// cart table-->
        <?php else : ?>
          <div class="page-cart__empty">
            <h1 class="page-cart__title page-cart__title-wrapper">
              <?php echo h(__('product-list.header.fav.empty', [], 'product-list'));?>
            </h1>
            <a href="<?php echo HOST;?>shop" class="button button--primary button--m">
              <?php echo h(__('button.products.add', [], 'buttons'));?>
            </a>
          </div>
        <?php endif; ?>

      </div>

    </div>
  </section>
</main>

