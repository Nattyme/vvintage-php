<!-- About -->
<h3 class="admin-section-title">Обо мне</h3>
<div class="admin-form__item" data-control="tab">
  <!-- Навигация -->
  <div class="tab__nav" data-control="tab-nav">
    <button type="button" class="tab__nav-button active" data-control="tab-button" 
            title="Перейти к редактированию заголовка секции 'Обо мне' на странице 'Контакты'">
            Заголовок
    </button>
    <button type="button" class="tab__nav-button" data-control="tab-button" 
            title="Перейти к редактированию содержимого страницы услуги">
            Содержимое поста 
    </button>
  </div>
  <!-- Навигация -->

  <!-- Блоки с контентом -->
  <div class="admin-form__item">
    <div class="tab__content" data-control="tab-content">
      <div class="tab__block active" data-control="tab-block">
        <label class="input__label">
          <input name="about_title" 
            class="input input--width-label" 
            type="text" 
            placeholder="Заголовок секции 'Обо мне'" 
            value="<?php echo isset($_POST['about_title']) ? $_POST['about_title'] : $contacts['about_title']; ?>"
          />
        </label>
      </div>
      <div class="tab__block" data-control="tab-block">
        <label class="textarea__label mb-15" name="editor"></label>
        <textarea name="about_text" class="textarea textarea--width-label" placeholder="Введите текст" id="about_text">
          <?php echo isset($_POST['about_text']) ? $_POST['about_text'] : $contacts['about_text']; ?>
        </textarea>
      </div>
    
    </div>
  </div>
  <!--// Блоки с контентом -->
</div>
