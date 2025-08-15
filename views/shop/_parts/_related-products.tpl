<section class="see-also">
    <div class="container">
      <div class="see-also__content">
        <div class="section-title">
          <h2 class="h2">Связанные товары</h2>
        </div>
        
        <div class="cards-row">
          <?php foreach($viewModel['related'] as $product) : ?>
            <?php 
                $images = $viewModel['imagesByProductId'][$product->getId()] ?? null;
                $mainImage = $images['main'] ?? null;
            ?>
            <?php include ROOT . 'views/shop/_parts/_card.tpl';?>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>