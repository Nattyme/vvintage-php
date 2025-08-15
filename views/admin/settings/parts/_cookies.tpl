
<!-- Form -->
<section class="p-4 py-4 mb-4 bg-light rounded-3">
  <form class="admin-form" method="POST" action="<?= HOST ?>admin/settings-cookies" id="cookies-form">

    <h5 class="mb-4">Данные для попапа</h5>
    <hr>

    <div class="col-12 my-4">
      <label for="link" class="form-label">Ссылка на политику обработки персональных
        данных:</label>

      <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon3">https://</span>
        <input type="text" name="link" class="form-control" id="link" placeholder="site.ru/privacy"
          autocomplete="off">
      </div>

    </div>

    <div class="form-check ">
      <input type="checkbox" class="form-check-input" id="metrika" name="metrika">
      <label class="form-check-label" for="metrika">Использование Яндекс Метрики</label>
    </div>

    <h5 class="mt-4">Расположение попапа</h5>
    <hr>

    <div class="row">
      <div class="col-md-4">
        <div class="form-check ">
          <input type="radio" name="position" value="left" class="form-check-input" id="left">
          <label class="form-check-label" for="left">Слева</label>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-check ">
          <input type="radio" name="position" value="center" class="form-check-input" id="center">
          <label class="form-check-label" for="center">По центру</label>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-check ">
          <input type="radio" name="position" value="right" class="form-check-input" id="right"
            checked>
          <label class="form-check-label" for="right">Справа</label>
        </div>
      </div>
    </div>

  </form>
</section>

<!-- Preview -->
<section class="h-100 p-4 bg-light border rounded-3 mb-4" id="popupPreview">

</section>

<!-- Code -->
<section class="h-100 p-4 mb-4 bg-light rounded-3">

  <h6>Поместите стили внутри тега <code>&lt;head&gt;</code></h6>
  <textarea class="w-100 form-control mb-4" id="codeCSS" rows="4"></textarea>
  <button id="copyCSS" class="btn btn-secondary mb-4">Копировать</button>

  <h6>Поместите разметку попапа после открывающего тега <code>&lt;body&gt;</code></h6>
  <textarea class="w-100 form-control mb-2" id="codeHTML" rows="4"></textarea>
  <button id="copyHTML" class="btn btn-secondary mb-4">Копировать</button>

  <h6>Поместите скрипт попапа перед закрывающим тегом <code>&lt;/body&gt;</code></h6>
  <textarea class="w-100 form-control mb-2" id="codeJS" rows="4"></textarea>
  <button id="copyJS" class="btn btn-secondary mb-4">Копировать</button>

</section>
