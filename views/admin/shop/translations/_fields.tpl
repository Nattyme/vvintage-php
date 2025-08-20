<div class="lang-group lang-group--<?php echo $code;?>" data-lang="<?php echo $code;?>">
  <div class="admin-form__field">
    <label class="admin-form__label" for="title-<?php echo $code;?>">Название продукта</label>
    <input 
      id="title-<?php echo $code;?>" 
      name="translations[<?php echo $code;?>][title]" 
      class="admin-form__input" 
      type="text" 
      placeholder="Введите название продукта" 
      value="<?php 
          echo isset($_POST['translations'][$code]['title']) 
          ? h($_POST['translations'][$code]['title']) 
          : (isset($product) && $product->getTranslatedTitle($code) 
          ? h($product->getTranslatedTitle($code)) : '');
      ?>"
    />
  </div>

  <div class="admin-form__field">
    <label class="admin-form__label" for="description-<?php echo $code;?>">Описание продукта</label>
    <textarea 
      id="description-<?php echo $code;?>" 
      name="translations[<?php echo $code;?>][description]" 
      class="admin-form__textarea" 
      placeholder="Введите описание бренда"
    ><?php 
      echo isset($_POST['translations'][$code]['description']) 
      ? h($_POST['translations'][$code]['description']) 
      : (isset($product) && $product->getTranslatedDescription($code) 
      ? h($product->getTranslatedDescription($code)) : '');
    ?></textarea>
  </div>


  <div class="admin-form__field">
    <label class="admin-form__label" for="meta_title-<?php echo $code;?>">SEO заголовок страницы</label>
    <input 
      id="meta_title-<?php echo $code;?>" 
      name="translations[<?php echo $code;?>][meta_title]" 
      class="admin-form__input" 
      type="text" 
      placeholder="Введите SEO заголовок страницы" 
      value="<?php 
        echo isset($_POST['translations'][$code]['meta_title']) 
        ? h($_POST['translations'][$code]['meta_title']) 
        : (isset($product) && $product->getSeoTitle($code) 
        ? h($product->getSeoTitle($code)) : '');
      ?>"
    />
  </div>

  <div class="admin-form__field">
    <label class="admin-form__label" for="meta_description-<?php echo $code;?>">SEO описание страницы</label>
    <textarea 
      id="meta_description-<?php echo $code;?>" 
      name="translations[<?php echo $code;?>][meta_description]" 
      class="admin-form__textarea" 
      placeholder="Введите SEO описание страницы"
    ><?php 
      echo isset($_POST['translations'][$code]['meta_description']) 
      ? h($_POST['translations'][$code]['meta_description']) 
      : (isset($product) && $product->getSeoDescription($code) 
      ? h($product->getSeoDescription($code)) : '');
    ?></textarea>
  </div>
</div>
