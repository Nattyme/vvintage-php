
<section class="arrival" id="arrival">
    <div class="container">
      <div class="section-title">
        <h2 class="h2">Новинки магазина</h2>
      </div>

      <div class="arrival__cards-wrapper">
        <div class="cards-row">
          <?php foreach($newProducts as $product) : ?>
            <?php include ROOT . 'templates/main/_parts/_product-card.tpl';?>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="arrival__button">
        <a href="<?php echo HOST . 'shop';?>" class="button button--outline">Открыть магазин</a>
      </div>
    </div>
  </section>