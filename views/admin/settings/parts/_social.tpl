<div class="tab" data-control="tab">
  <!-- Навигация -->
  <div class="tab__nav" data-control="tab-nav">
    <button type="button" class="button button--m button--tab active" data-control="tab-button" 
            title="Перейти в редактирование ссылки на профиль youtube">
      Youtube
    </button>

    <button type="button" class="button button--m button--tab" data-control="tab-button" 
            title="Перейти в редактирование ссылки на профиль instagram">
      Instagram
    </button>

    <button type="button" class="button button--m button--tab " data-control="tab-button" 
            title="Перейти в редактирование ссылки на профиль facebook">
      Facebook
    </button>

    <button type="button" class="button button--m button--tab " data-control="tab-button" 
            title="Перейти в редактирование ссылки на профиль vkontakte">
      Вконтакте
    </button>

    <button type="button" class="button button--m button--tab " data-control="tab-button" 
            title="Перейти в редактирование ссылки на профиль яндекс дзен">
      Яндекс Дзен
    </button>

    <button type="button" class="button button--m button--tab " data-control="tab-button" 
            title="Перейти в редактирование ссылки на профиль телеграм">
      Телеграм
    </button>
  </div>
  <!-- Навигация -->

  <!-- Блоки с контентом -->
  <div class="tab__content" data-control="tab-content">
  
    <div class="tab__block tab__block--social  active" data-control="tab-block">
      <label class="visually-hidden input__label" for="youtube">Youtube</label>
      <input name="youtube" class="input" type="text" placeholder="Введите ссылку на профиль youtube" id="youtube" 
              value="<?php echo isset($_POST['youtube']) ? $_POST['youtube'] : $settings['youtube']; ?>" 
      />
    </div>

    <div class="tab__block tab__block--social " data-control="tab-block">
      <label class="visually-hidden input__label" for="instagram">Instagram</label>
      <input name="instagram" class="input" type="text" placeholder="Введите ссылку на профиль instagram" id="instagram" 
            value="<?php echo isset($_POST['instagram']) ? $_POST['instagram'] : $settings['instagram']; ?>" 
      />
    </div>

    <div class="tab__block tab__block--social " data-control="tab-block">
      <label class="visually-hidden input__label" for="facebook">Facebook</label>
      <input name="facebook" class="input input--width-label" 
              type="text" placeholder="Введите ссылку на профиль facebook" 
              id="facebook"
              value="<?php echo isset($_POST['facebook']) ? $_POST['facebook'] : $settings['facebook']; ?>" 
      />
    </div>

    <div class="tab__block tab__block--social " data-control="tab-block">
      <label class="visually-hidden input__label" for="vkontakte">Vkontakte</label>
      <input name="vkontakte" class="input" type="text" placeholder="Введите ссылку на профиль vkontakte" id="vkontakte"
            value="<?php echo isset($_POST['vkontakte']) ? $_POST['vkontakte'] : $settings['vkontakte']; ?>" 
      />
    </div>

    <div class="tab__block tab__block--social " data-control="tab-block">
      <label class="visually-hidden input__label" for="dzen">Dzen</label>
      <input name="dzen" class="input" type="text" placeholder="Введите ссылку на профиль яндекс дзен" id="dzen"
            value="<?php echo isset($_POST['dzen']) ? $_POST['dzen'] : $settings['dzen']; ?>" 
      />
    </div>

    <div class="tab__block tab__block--social " data-control="tab-block">
      <label class="visually-hidden input__label" for="telegram">Telegram</label>
      <input name="telegram" class="input" type="text" placeholder="Введите ссылку на профиль telegram" id="telegram"
            value="<?php echo isset($_POST['telegram']) ? $_POST['telegram'] : $settings['telegram']; ?>" 
      />
    </div>
  </div>
  <!--// Блоки с контентом -->
</div>



