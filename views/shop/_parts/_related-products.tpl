<section class="see-also">
    <div class="container">
      <div class="see-also__content">
        <div class="section-title">
          <h2 class="h2">Связанные товары</h2>
        </div>
        
        <div class="cards-row">
          <?php foreach($productViewModel['related'] as $product) : ?>
            <?php include ROOT . 'views/shop/_parts/_card.tpl';?>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>