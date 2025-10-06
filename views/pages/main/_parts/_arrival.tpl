
<section class="arrival" id="arrival">
    <div class="container">
      <div class="section-title">
        <h2 class="h2 text-bold">
          <?php echo h($fields['new_products_title']);?>
        </h2>
      </div>

      <div class="arrival__cards-wrapper">
        <div class="cards-row">
          <?php foreach($products as $product) : ?>
            <?php include ROOT . 'views/pages/main/_parts/_product-card.tpl'; ?>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="arrival__button">
        <a href="<?php echo HOST . 'shop';?>" class="button button--l button--outline">
          <?php echo h(__('button.goto.shop', [], 'buttons'));?>
        </a>
      </div>
    </div>
  </section>