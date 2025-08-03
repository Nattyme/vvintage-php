<div class="lang-group lang-group--ru" data-lang="ru">
  <div class="admin-form__field">
    <label class="admin-form__label" for="title-ru">Название бренда</label>
    <input 
      id="title-ru" 
      name="title[ru]" 
      class="admin-form__input" 
      type="text" 
      placeholder="Заголовок бренда" 
      value="<?php echo h(trim($brand->getTranslation('en')['title'] ?? ''));?>"
    />

  </div>
  <div class="admin-form__field">
    <label class="admin-form__label" for="description-ru">Описание</label>
    <textarea id="description-ru" name="description[ru]" class="admin-form__textarea" placeholder="Описание бренда"></textarea>
  </div>
  <div class="admin-form__field">
    <label class="admin-form__label" for="meta_title-ru">Meta Title</label>
    <input id="meta_title-ru" name="meta_title[ru]" class="admin-form__input" type="text" placeholder="Meta Title" />
  </div>
  <div class="admin-form__field">
    <label class="admin-form__label" for="meta_description-ru">Meta Description</label>
    <textarea id="meta_description-ru" name="meta_description[ru]" class="admin-form__textarea" placeholder="Meta Description"></textarea>
  </div>
</div>
