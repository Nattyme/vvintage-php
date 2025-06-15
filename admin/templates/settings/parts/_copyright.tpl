<div class="admin-form__field" data-control="tab">
  <h3 class="h2 text-bold">Копирайт в подвале</h3>

  <!-- Навигация -->
  <div class="admin-form__field buttons" data-control="tab-nav">
    <button type="button" class="button button--m button--outline active" data-control="tab-button" 
            title="Перейти в редактирование текста первой строки копирайта">
      Копирайт 1ая
    </button>
    <button type="button" class="button button--m button--outline" data-control="tab-button" 
            title="Перейти в редактирование текста второй строки копирайта">
      Копирайт 2ая
    </button>
  </div>
  <!-- Навигация -->

 <!-- Блоки с контентом -->
  <div class="admin-form__field" data-control="tab-content">
    <div class="tab__block active" data-control="tab-block">
      <input name="copyright_name" class="input" 
              type="text" placeholder="Введите текст первой строки копирайта" 
              value="<?php echo isset($_POST['copyright_name']) ? $_POST['copyright_name'] : $settings['copyright_name']; ?>" 
      />
    </div>
    
    <div class="tab__block" data-control="tab-block">
      <input name="copyright_year" class="input" 
              type="text" placeholder="Введите текст второй строки копирайта" 
              value="<?php echo isset($_POST['copyright_year']) ? $_POST['copyright_year'] : $settings['copyright_year']; ?>" 
      />
    </div>

  </div>
  <!--// Блоки с контентом -->

</div>
