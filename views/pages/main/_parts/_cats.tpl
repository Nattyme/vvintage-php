<section class="cats" id="cats">
  <div class="container">
    <div class="section-title">
      <h2 class="h2 text-bold">
        <?php echo h($fields['categories_title']['value']);?>
      </h2>
    </div>

    <div class="cats__cards-wrapper">
      <div class="cards-row">
        <?php foreach ($categories as $category) : ?>
          <?php include ROOT . 'views/pages/main/_parts/_cat-card.tpl';?>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>