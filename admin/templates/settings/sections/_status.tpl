<div class="admin-form__field">
  <h3 class="admin-section-title">Секция "Статус"</h3>

<div class="admin-form__item" data-control="tab">
  <!-- Навигация -->
  <div class="tab__nav" data-control="tab-nav">
    <button type="button" class="tab__nav-button active" data-control="tab-button" 
            title="Перейти в редактирование текст на кнопке статуса">
      Текст на кнопке
    </button>
    <button type="button" class="tab__nav-button" data-control="tab-button" 
            title="Перейти в редактирование текста статуса справа">
      Текст справа
    </button>
    <button type="button" class="tab__nav-button" data-control="tab-button" 
            title="Перейти в редактирование ссылки статуса">
      Ссылка
    </button>
  </div>
  <!-- Навигация -->

  <!-- Блоки с контентом -->
  <div class="admin-form__item">
    <div class="tab__content" data-control="tab-content">
      <div class="tab__block active" data-control="tab-block">
        <label class="input__label">
          <input name="status_label" class="input input--width-label" 
                 type="text" placeholder="Введите текст кнопки статуса" 
                 value="<?php echo isset($_POST['status_label']) ? $_POST['status_label'] : $settings['status_label']; ?>" 
          />
        </label>
      </div>
      
      <div class="tab__block" data-control="tab-block">
        <label class="input__label">
          <input name="status_text" class="input input--width-label" 
                 type="text" placeholder="Введите текст статуса справа" 
                 value="<?php echo isset($_POST['status_text']) ? $_POST['status_text'] : $settings['status_text']; ?>" 
          />
        </label>
      </div>

      <div class="tab__block" data-control="tab-block">
        <label class="input__label">
          <input name="status_link" class="input input--width-label" 
                 type="text" placeholder="Введите ссылку статуса" 
                 value="<?php echo isset($_POST['status_link']) ? $_POST['status_link'] : $settings['status_link'];?>" 
          />
        </label>
      </div>
    
    </div>
  </div>
  <!--// Блоки с контентом -->
</div>

<div class="admin-form__item">
  <label class="checkbox__item">
      <input
          class="checkbox__btn"
          type="checkbox"
          name="status_on"
          <?php echo !empty($settings['status_on']) ? 'checked' : NULL;  ?>
      >
      <span class="checkbox__label"><strong>Показывать секцию статус</strong></span>
  </label>
</div>

</div>

