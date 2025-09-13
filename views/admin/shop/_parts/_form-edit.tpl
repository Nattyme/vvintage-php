<form 
  id="form-edit" 
  method="POST" 
  class="admin-form" 
  enctype="multipart/form-data"
  data-product="<?php echo h($product->getId());?>"
>

  <div class="admin-form__row">
    <div class="admin-form__column">
      
      <input type="hidden" name="_method" value="PUT">
    
      <div class="admin-form__field">
        <label class="admin-form__label" for="title">Дата последнего обновления</label>
      
        <input  id="title" name="title" class="admin-form__input input" type="text"
                value="<?php echo h(rus_date('j. m. Y. H:i', $product->getEditTime()));?>"
                placeholder="Введите название" disabled
        />
      </div>
      <div class="admin-form__field">
        <div class="admin-form__item" data-control="tab">
          <!-- Навигация -->
          <div class="tab__nav" data-control="tab-nav">
            <?php $firstKey = array_key_first($languages); ?>
            <?php foreach ($languages as $code => $value ) : ?>
              <button type="button" class="tab__nav-button tab__nav-button--flags <?php echo $code === $firstKey ? 'active' : ''; ?>" data-control="tab-button" 
                      title="Перейти в редактирование текст на кнопке статуса">
                <img src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#flag-' . $code;?>">
              </button>
            <?php endforeach;?>
          </div>
          <!-- Навигация -->

          <!-- Блоки с контентом -->
          <div class="admin-form__item">
            <div class="tab__content" data-control="tab-content">
              <?php $firstKey = array_key_first($languages); ?>
              <?php foreach ($languages as $code => $value ) : ?>
                <div class="tab__block  <?php echo $code === $firstKey ? 'active' : ''; ?>" data-control="tab-block">
                  <?php include ROOT . "views/admin/shop/translations/_fields.tpl";?>
                </div>
              <?php endforeach;?>
            </div>
          </div>
          <!--// Блоки с контентом -->
        </div>
      </div>


      <div class="admin-form__field">
        <label class="admin-form__label" for="title">Название для страницы товара (латиницей: chasy-chanel)</label>
        <input id="slug" name="slug" class="admin-form__input input" type="text"
                value="<?php echo isset($_POST['slug']) ? h($_POST['slug']) : h($product->getSlug()); ?>"
                placeholder="Введите название старницы" required/>
      </div>

      <div class="admin-form__field">
        <label class="admin-form__label" for="price">Цена</label>
        <input id="price" name="price" class="admin-form__input input" type="text"
                value="<?php echo isset($_POST['getPrice']) ? h($_POST['getPrice']) : h($product->getPrice()); ?>"
                placeholder="Введите цену в &euro;" required
        />
      </div>

      <div class="admin-form__field">
        <label class="admin-form__label" for="sku">Артикул</label>
        <input id="sku" name="sku" class="admin-form__input input" type="text"
                value="<?php echo isset($_POST['sku']) ? h($_POST['sku']) : h($product->getSku()); ?>"
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
        <input id="url" name="url" class="admin-form__input input" type="text"
                value="<?php echo isset($_POST['url']) ? h($_POST['url']) : h($product->getUrl()); ?>"
                placeholder="Введите ссылку на vinted.fr" 
                required
        />
                  
      </div>

      
      <div class="admin-form__field">
          <label class="admin-form__label" for="mainCat">Раздел</label>
          <div class="admin-form__row">
            <select class="select" name="mainCat" id="category" data-current-parent="<?php echo h($product->getCategory()->getParentId()) ?>"></select>
      
            <a 
              class="button button--s button--primary" 
              href="<?php echo HOST . 'category-new';?>">
                Новая категория
            </a>
          </div>
      </div>

      <div class="admin-form__field">
          <label class="admin-form__label" for="subCat">Категория</label>
          <div class="admin-form__row">
              <select class="select" name="category_id" id="subCategory" data-current-cat="<?php echo h($product->getCategory()->getId()) ?>"></select>
  
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
          <select class="select" name="brand_id" id="brands" data-brand="<?php echo h($product->getBrandId());?>"></select>
  
          <a 
            class="button button--s button--primary" 
            href="<?php echo HOST . 'brand-new';?>">
              Новый бренд
          </a>
        </div>
      </div>


        <div class="admin-form__field">
            <label class="admin-form__label" for="status">Статус</label>
            <div class="admin-form__row">
            
              <select class="select" name="status" id="status">
                <?php foreach ($statusList as $key => $value) : ?>
                  <option <?php echo $product->getStatus() === $key ? 'selected' : '';?> value="<?php echo h($key);?>">
                    <?php echo h($value);?>
                  </option>
                <?php endforeach; ?>
              </select>
              
            </div>
        </div>
    </div>

    <div class="admin-form__column admin-form__column--imgs">
   
      <?php foreach ($product->getImages() as $img): ?>
          <input type="hidden" name="existing_images[]" value="<?php echo h($img->getId()); ?>">
      <?php endforeach; ?>
    
      <div class="admin-form__field">
      
          <label class="admin-form__label" for="file">Фотографии товара</label>
          <div class="block-upload" data-preview="block" data-dragg-and-drop>
            <div class="block-upload__description">
              <p class="block-upload__title">
                Изображение jpg или png, рекомендуемая ширина 945px и больше, высота от 400px и более. Вес до 2Мб.
              </p>
            </div>

            <!-- PREVIEW IMG -->
            <div class="block-upload__preview" data-preview="container" data-dragg-preview>
              <?php foreach ($product->getImages() as $image) : ?>
                <div 
                    class="block-upload__img-wrapper" 
                    data-preview="image-wrapper" 
                    draggable="true" 
                    data-url="<?php echo HOST . 'usercontent/products/' . '350-' . $image->getFilename();?>"
                    data-id="<?php echo $image->getId();?>"
                    data-name="<?php echo $image->getFilename();?>"
                    data-order="<?php echo $image->getOrder();?>"
                >
                  <img 
                    id = "<?php echo $image->getId();?>"
                    src="<?php echo HOST . 'usercontent/products/' . '350-' . $image->getFilename();?>" 
                    loading="lazy"
                           
                  >

      
                  <button type="button" class="button button--close button--close-with-bg cross-wrapper" data-preview="btn-close">
                      <span class="leftright"></span><span class="rightleft"> </span>
                  </button>
               
                </div>
              <?php endforeach;?>
            </div>
            <div class="block-upload__dropzone" data-dragg-dropzone>
              <p>Перетащите файлы сюда</p>
              или нажмите на кнопку 
              <div class="block-upload__button admin-form__block-upload__button">
                <!-- Кастомная кнопка -->
                <button type="button" class="btn-add-photo" id="btn-add-photo">
                  <svg class="icon icon--add_photo">
                    <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#add_photo';?>"></use>
                  </svg>
                </button>
                <input id="file" name="cover[]" class="block-upload__input-real" type="file" multiple data-preview="input" hidden>
              </div>
            </div>
            <!-- // PREVIEW IMG -->
          </div>
        </label>
      </div>
    </div>
  </div>

  <!-- CSRF-токен -->
  <input type="hidden" name="csrf" value="<?php echo h(csrf_token()) ;?>">

  <div class="admin-form__button-wrapper admin-form__button-row">
    <?php if (isset($_POST['submit'])) : ?>
      <a class="button button--m button--outline" href="<?php echo HOST . 'admin/shop';?>" title="Вернуться к списку товаров">К списку товаров</a>
    <?php else : ?>
      <a class="button button--m button--outline" href="<?php echo HOST . 'admin/shop';?>" title="Отмена">Отмена</a>
    <?php endif; ?>
    <button class="button button--m button--primary" type="submit" name="submit" value="submit">Сохранить</button>
  </div>
</form>