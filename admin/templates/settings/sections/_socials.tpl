<div class="admin-form__field" data-control="tab">
  <h3 class="h3 text-bold">Социальные ссылки</h3>

  <!-- Навигация -->
  <div class="admin-form__field buttons" data-control="tab-nav">
    <button type="button" class="button button--m button--outline active" data-control="tab-button" 
            title="Перейти в редактирование ссылки на профиль youtube">
      Youtube
    </button>

    <button type="button" class="button button--m button--outline" data-control="tab-button" 
            title="Перейти в редактирование ссылки на профиль instagram">
      Instagram
    </button>

    <button type="button" class="button button--m button--outline" data-control="tab-button" 
            title="Перейти в редактирование ссылки на профиль facebook">
      Facebook
    </button>

    <button type="button" class="button button--m button--outline" data-control="tab-button" 
            title="Перейти в редактирование ссылки на профиль vkontakte">
      Вконтакте
    </button>

    <button type="button" class="button button--m button--outline" data-control="tab-button" 
            title="Перейти в редактирование ссылки на профиль яндекс дзен">
      Дзен
    </button>
  </div>
  <!-- Навигация -->

  <!-- Блоки с контентом -->
  <div class="admin-form__field" data-control="tab-content">
  
    <div class="tab__block active" data-control="tab-block">
      <input name="youtube" class="input" type="text" placeholder="Введите ссылку на профиль youtube" 
              value="<?php echo isset($_POST['youtube']) ? $_POST['youtube'] : $settings['youtube']; ?>" 
      />
    </div>

    <div class="tab__block" data-control="tab-block">
      <input name="instagram" class="input" type="text" placeholder="Введите ссылку на профиль instagram" 
            value="<?php echo isset($_POST['instagram']) ? $_POST['instagram'] : $settings['instagram']; ?>" 
      />
    </div>

    <div class="tab__block" data-control="tab-block">
      <label class="input__label">
        <input name="facebook" class="input input--width-label" type="text" placeholder="Введите ссылку на профиль facebook" 
              value="<?php echo isset($_POST['facebook']) ? $_POST['facebook'] : $settings['facebook']; ?>" 
        />
      </label>
    </div>

    <div class="tab__block" data-control="tab-block">
      <input name="vkontakte" class="input" type="text" placeholder="Введите ссылку на профиль vkontakte"
            value="<?php echo isset($_POST['vkontakte']) ? $_POST['vkontakte'] : $settings['vkontakte']; ?>" 
      />
    </div>
    <div class="tab__block" data-control="tab-block">
      <input name="dzen" class="input" type="text" placeholder="Введите ссылку на профиль яндекс дзен"
            value="<?php echo isset($_POST['dzen']) ? $_POST['dzen'] : $settings['dzen']; ?>" 
      />
    </div>
  </div>
  <!--// Блоки с контентом -->
</div>



