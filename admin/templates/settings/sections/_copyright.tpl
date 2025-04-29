<h3 class="admin-section-title">Копирайт в подвале</h3>

<div class="admin-form__item" data-control="tab">
  <!-- Навигация -->
  <div class="tab__nav" data-control="tab-nav">
    <button type="button" class="tab__nav-button active" data-control="tab-button" 
            title="Перейти в редактирование текста первой строки копирайта">
      Копирайт первая строка
    </button>
    <button type="button" class="tab__nav-button" data-control="tab-button" 
            title="Перейти в редактирование текста второй строки копирайта">
      Копирайт вторая строка
    </button>
  </div>
  <!-- Навигация -->

  <!-- Блоки с контентом -->
  <div class="admin-form__item">
    <div class="tab__content" data-control="tab-content">
      <div class="tab__block active" data-control="tab-block">
        <label class="input__label">
          <input name="copyright_name" class="input input--width-label" 
                 type="text" placeholder="Введите текст первой строки копирайта" 
                 value="<?php echo isset($_POST['copyright_name']) ? $_POST['copyright_name'] : $settings['copyright_name']; ?>" 
          />
        </label>
      </div>
      
      <div class="tab__block" data-control="tab-block">
        <label class="input__label">
          <input name="copyright_year" class="input input--width-label" 
                 type="text" placeholder="Введите текст второй строки копирайта" 
                 value="<?php echo isset($_POST['copyright_year']) ? $_POST['copyright_year'] : $settings['copyright_year']; ?>" 
          />
        </label>
      </div>

    </div>
  </div>
  <!--// Блоки с контентом -->
</div>
