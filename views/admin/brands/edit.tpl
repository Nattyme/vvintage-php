<div class="admin-page__content-form">
  
  <?php include ROOT . "views/components/errors.tpl"; ?>
  <?php include ROOT . "views/components/success.tpl"; ?>

  <form class="admin-form" method="POST" action="<?php echo HOST;?>admin/brand-new">
    <!-- Языковой селект -->
    <div class="admin-form__field admin-form__language-select">
      <label class="admin-form__label" for="language-select">Выберите язык</label>
      <select id="language-select" class="admin-form__input">
        <?php foreach ($languages as $code => $label): ?>
          <option value="<?php echo h($code) ?>" <?php echo ($code === $currentLang) ? 'selected' : '';?>>
            <?php echo h($label);?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <?php foreach ($languages as $code => $label): ?>
      <div class="lang-group" data-lang="<?= h($code) ?>" style="<?= $code === 'ru' ? '' : 'display: none;' ?>">
        <?php include 'views/admin/brands/translations/translation_fields.tpl'; ?>
      </div>
    <?php endforeach; ?>


    <!-- Контейнер для языковых полей -->
    <div class="admin-form__fields-langs">
      <!-- Русский -->
      <?php include 'views/admin/brands/translations/ru_fields.tpl'; ?>
      <!-- Немецкий -->
      <?php include 'views/admin/brands/translations/de_fields.tpl'; ?>
      <!-- Английский -->
      <?php include 'views/admin/brands/translations/en_fields.tpl'; ?>
      <!-- Испанский -->
      <?php include 'views/admin/brands/translations/es_fields.tpl'; ?>
      <!-- Французский -->
      <?php include 'views/admin/brands/translations/fr_fields.tpl'; ?>
      <!-- Японский -->
      <?php include 'views/admin/brands/translations/ja_fields.tpl'; ?>
      <!-- Китайский -->
      <?php include 'views/admin/brands/translations/zh_fields.tpl'; ?>
      
    </div>

    <!-- CSRF-токен -->
    <input type="hidden" name="csrf" value="<?php echo h(csrf_token()) ;?>">

    <div class="admin-form__buttons buttons">
      <button name="submit" value="submit" class="button button--m button--primary" type="submit">Создать</button>
      <a class="button button--m button--outline" href="<?php echo HOST . 'admin/brand';?>">Отмена</a>
    </div>
  </form>
</div>
<script>
document.getElementById('language-select').addEventListener('change', function() {
  const selectedLang = this.value;
  document.querySelectorAll('.lang-group').forEach(group => {
    group.style.display = group.dataset.lang === selectedLang ? 'block' : 'none';
  });
});

</script>
