<div class="admin-form__field" data-control="tab">
  <h3 class="h2 text-bold">Общие</h3>

<!-- Навигация -->
<div class="admin-form__field buttons" data-control="tab-nav">
  <button type="button" class="button button--m button--outline active" data-control="tab-button" 
          title="Перейти к редактированию названия сайта">
          Название сайта
  </button>
  <button type="button" class="button button--m button--outline" data-control="tab-button" 
          title="Перейти к редактированию слогана сайта">
          Слоган
  </button>
</div>
<!-- Навигация -->

<div class="admin-form__field" data-control="tab-content">
  <!-- Блоки с контентом -->
  <div class="tab__block active" data-control="tab-block">
      <input
        id = "site_title"
        name="site_title"
        class="input"
        type="text"
        placeholder="Введите название сайте" 
        value="<?php echo isset($_POST['site_title']) ? $_POST['site_title'] : $settings['site_title']; ?>" 
      />
  </div>
  <div class="tab__block" data-control="tab-block">
    <input
      id="site_slogan"
      name="site_slogan"
      class="input"
      type="text"
      placeholder="Введите слоган сайта"
      value="<?php echo isset($_POST['site_slogan']) ? $_POST['site_slogan'] : $settings['site_slogan']; ?>" 
    />
  </div>
  <!--// Блоки с контентом -->
</div>

</div>
