<div class="admin-form__field" data-control="tab">
  <h3 class="h2 text-bold">Отображение карточек на страницах</h3>

  <!-- Навигация -->
  <div class="admin-form__field buttons" data-control="tab-nav">
    <button type="button" class="button button--m button--outline active" data-control="tab-button" 
            title="Перейти в редактирование ссылки на профиль youtube">
      Магазин
    </button>

    <button type="button" class="button button--m button--outline" data-control="tab-button" 
            title="Перейти в редактирование ссылки на профиль instagram">
      Блог
    </button>
  </div>
  <!-- Навигация -->

  <div class="admin-form__field"  data-control="tab-content">
    <!-- Блоки с контентом -->
    <div class="tab__block active" data-control="tab-block">
      <input name="card_on_page_shop" class="input" type="text" 
                placeholder="Введите количество продуктов на странице магазина" 
                value="<?php echo isset($_POST['card_on_page_shop']) ? $_POST['card_on_page_shop'] : $settings['card_on_page_shop'];?>" 
      />
    </div>

    <div class="tab__block" data-control="tab-block">
      <input name="card_on_page_blog" class="input" type="text" 
              placeholder="Введите количество постов на странице блога" 
              value="<?php echo isset($_POST['card_on_page_blog']) ? $_POST['card_on_page_blog'] : $settings['card_on_page_blog'];?>" 
      />
    </div>

    <div class="tab__block" data-control="tab-block">
      <input name="card_on_page_portfolio" class="input" type="text" 
              placeholder="Введите количество проектов на странице в портфолио"  
              value="<?php echo isset($_POST['card_on_page_portfolio']) ? $_POST['card_on_page_portfolio'] : $settings['card_on_page_portfolio']; ?>" 
      />
    </div>
    <!--// Блоки с контентом -->
  </div>

</div>
