<h3 class="admin-section-title">Общие</h3>

<div class="admin-form__item" data-control="tab">
  <!-- Навигация -->
  <div class="tab__nav" data-control="tab-nav">
    <button type="button" class="tab__nav-button active" data-control="tab-button" 
            title="Перейти к редактированию названия сайта">
            Название сайта
    </button>
    <button type="button" class="tab__nav-button" data-control="tab-button" 
            title="Перейти к редактированию слогана сайта">
            Слоган
    </button>
  </div>
  <!-- Навигация -->

  <!-- Блоки с контентом -->
  <div class="admin-form__item">
    <div class="tab__content" data-control="tab-content">
      <div class="tab__block active" data-control="tab-block">
        <label class="input__label">
          <input
            name="site_title"
            class="input input--width-label"
            type="text"
            placeholder="Введите название сайте" 
            value="<?php echo isset($_POST['site_title']) ? $_POST['site_title'] : $settings['site_title']; ?>" 
          />
        </label>
      </div>
      <div class="tab__block" data-control="tab-block">
        <label class="input__label">
          <input
            name="site_slogan"
            class="input input--width-label"
            type="text"
            placeholder="Введите слоган сайта"
            value="<?php echo isset($_POST['site_slogan']) ? $_POST['site_slogan'] : $settings['site_slogan']; ?>" 
          />
        </label>
      </div>
    
    </div>
  </div>
  <!--// Блоки с контентом -->
</div>
