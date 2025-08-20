<form id="form-add-product" method="POST" class="admin-form" enctype="multipart/form-data">
  <div class="admin-form__row">
    <div class="admin-form__column">
      <div class="admin-form__field">
        <label class="admin-form__label" for="title">Название товара</label>
        <input 
          id="title"
          name="title" 
          class="admin-form__input input" 
          type="text"
          value="<?php echo isset($_POST['title']) ? h($_POST['title']) : 'ппрпрпр';?>"
          placeholder="Введите название" 
          required
        />
      </div>

        <div class="admin-form__field">
        <label class="admin-form__label" for="title">Название для страницы товара (латиницей: chasy-chanel)</label>
        <input id="slug" name="slug" class="admin-form__input input" type="text"
                value="<?php echo isset($_POST['slug']) ? h($_POST['slug']) : '123456'; ?>"
                placeholder="Введите название старницы" required/>
      </div>

      <div class="admin-form__field">
        <label class="admin-form__label" for="price">Цена</label>
        <input 
          id="price"
          name="price" 
          class="admin-form__input input" 
          type="text"
          value="<?php echo isset($_POST['price']) ? h($_POST['price']) : 12345;?>"
          placeholder="Введите цену в &euro;" 
          required
        />
      </div>

      <div class="admin-form__field">
        <label class="admin-form__label" for="article">Артикул</label>
        <input 
          id="sku" 
          name="sku" 
          class="admin-form__input input" 
          type="text"
          value="<?php echo isset($_POST['sku']) ? h($_POST['sku']) : '123456';?>"
          placeholder="Введите артикул" 
        />
      </div>

      <div class="admin-form__field">
        <label class="admin-form__label" for="stock">Сток</label>
        <input 
          id="stock" 
          name="stock" 
          class="admin-form__input input" 
          type="text"
          value="<?php echo 1;?>"
          readonly
        />
      </div>

      <div class="admin-form__field">
        <label class="admin-form__label" for="url">Ссылка</label>
        <input 
          id="url"
          name="url" 
          class="admin-form__input input" 
          type="text"
          value="<?php echo isset($_POST['url']) ? u($_POST['url']) : 'https://nattyme.github.io/amid/';?>"
          placeholder="Введите ссылку на vinted.fr" 
        />
      </div>

      <div class="admin-form__field">
          <label class="admin-form__label" for="mainCat">Главный раздел</label>
          <div class="admin-form__row">
            <select class="select" name="mainCat" id="category"></select>
      
            <a 
              class="button button--s button--primary" 
              href="<?php echo HOST . 'category-new';?>">
                Новый раздел
            </a>
          </div>
      </div>

   
      <div class="admin-form__field">
          <label class="admin-form__label" for="subCat">Категория</label>
          <div class="admin-form__row">
              <select class="select" name="category_id" id="subCategory"></select>

              <a 
                class="button button--s button--primary" 
                href="<?php echo HOST . 'category-new';?>">
                  Новая категория
              </a>
          </div>
      </div>


      <div class="admin-form__field">
          <label class="admin-form__label" for="brands">Выберите бренд</label>
          <div class="admin-form__row">
            <select class="select" name="brand_id" id="brands"></select>
  
            <a 
              class="button button--s button--primary" 
              href="<?php echo HOST . 'brand-new';?>">
                Новый бренд
            </a>
          </div>
      </div>

      <div class="admin-form__field">
        <label class="admin-form__text" for="editor">Описание товара</label>
        <textarea class="admin-form__textarea" placeholder="Введите описание товара" name="description" rows="5" cols="1" id="editor">
          <?php echo isset($_POST['content']) ? h($_POST['content']) : 'Введите описание товара'; ?>
        </textarea>
      </div>

      <div class="admin-form__field">
          <label class="admin-form__label" for="status">Статус</label>
          <div class="admin-form__row">
            
              <select class="select" name="status" id="status">
              <?php foreach ($statusList as $key => $value) : ?>
                <option <?php echo isset($_POST['status']) &&  $_POST['status'] === $key ? 'selected' : '123456';?> value="<?php echo h($key);?>">
                  <?php echo h($value);?>
                </option>
              <?php endforeach; ?>
            </select>
            
          </div>
      </div>
    </div>

    <div class="admin-form__column admin-form__column--imgs">
      <div class="admin-form__field">
  
        <label class="admin-form__label">Фотографии товара</label>
        <div class="block-upload" data-preview="block">
          <div class="block-upload__description">
            <p class="block-upload__title">
              Изображение jpg или png, рекомендуемая ширина 945px и больше, высота от 400px и более. Вес до 2Мб.
            </p>
          </div>

          <div class="block-upload__button">
            <label class="block-upload__input-fake" for="file">Выбрать изображения</label>
            <input id="file" name="cover[]" class="block-upload__input-real" type="file" multiple data-preview="input">
          </div>

          <div class="block-upload__preview" data-preview="container" data-dragg-and-drop></div>
        </div>
        
      </div>
    </div>
  </div>

  <!-- CSRF-токен -->
  <input type="hidden" name="csrf" value="<?php echo h(csrf_token()) ;?>">

  <div class="admin-form__button-wrapper admin-form__button-row">
    <a class="button button--m button--outline" href="<?php echo HOST . 'admin/shop';?>">Отмена</a>
    <button class="button button--m button--primary" type="submit" name="submit" value="submit">Опубликовать</button>
  </div>
</form>