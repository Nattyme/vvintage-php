const addSectionCatalogTemplate = () => {
  return `
    <section class="catalog">
  <div class="catalog__container">
    <header class="catalog__header">
      <h2 class="h2">Каталог</h2>
    </header>

    <div class="catalog__content">
      <ul class="catalog-list" id="catalog-list"></ul>
      
      <!-- Заменить див ниже на ul -->
      <ul class="catalog-cards" id="catalog-cards"></ul>
    </div>

  </div>
</section>
  `;
} 

export default addSectionCatalogTemplate;