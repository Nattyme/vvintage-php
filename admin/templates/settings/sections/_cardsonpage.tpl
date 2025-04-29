<h3 class="admin-section-title">Отображение карточек на страницах</h3>

<div class="admin-form__item" data-control="tab">
  <!-- Навигация -->
  <div class="tab__nav" data-control="tab-nav">
    <button type="button" class="tab__nav-button active" data-control="tab-button" 
            title="Перейти в редактирование ссылки на профиль youtube">
      Магазин
    </button>

    <button type="button" class="tab__nav-button" data-control="tab-button" 
            title="Перейти в редактирование ссылки на профиль instagram">
      Блог
    </button>

    <button type="button" class="tab__nav-button" data-control="tab-button" 
            title="Перейти в редактирование ссылки на профиль facebook">
      Портфолио
    </button>
  </div>
  <!-- Навигация -->

  <!-- Блоки с контентом -->
  <div class="admin-form__item">
    <div class="tab__content" data-control="tab-content">
      <div class="tab__block active" data-control="tab-block">
        <label class="input__label">
          <input name="card_on_page_shop" class="input input--width-label" type="text" 
                 placeholder="Введите количество продуктов на странице магазина" 
                 value="<?php echo isset($_POST['card_on_page_shop']) ? $_POST['card_on_page_shop'] : $settings['card_on_page_shop'];?>" 
          />
        </label>
      </div>

      <div class="tab__block" data-control="tab-block">
        <label class="input__label">
            <input name="card_on_page_blog" class="input input--width-label" type="text" 
                   placeholder="Введите количество постов на странице блога" 
                   value="<?php echo isset($_POST['card_on_page_blog']) ? $_POST['card_on_page_blog'] : $settings['card_on_page_blog'];?>" 
            />
        </label>
      </div>

      <div class="tab__block" data-control="tab-block">
        <label class="input__label">
          <input name="card_on_page_portfolio" class="input input--width-label" type="text" 
                 placeholder="Введите количество проектов на странице в портфолио"  
                 value="<?php echo isset($_POST['card_on_page_portfolio']) ? $_POST['card_on_page_portfolio'] : $settings['card_on_page_portfolio']; ?>" 
          />
        </label>
      </div>

    </div>
  </div>
  <!--// Блоки с контентом -->
</div>
