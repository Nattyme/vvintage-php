<div class="lang-group lang-group--<?php echo $code;?>" data-lang="<?php echo $code;?>">
  <div class="admin-form__field">
    <label class="admin-form__label" for="title-<?php echo $code;?>">
      <?php if ($this->routeData->uriGet) : ?> 
          Название категории
        <?php else : ?>
          Название раздела
        <?php endif;?>
    </label>
    <input 
      id="title-<?php echo $code;?>" 
      name="translations[<?php echo $code;?>][title]" 
      class="admin-form__input" 
      type="text" 
      placeholder="Введите название категории" 
      value="<?php 
          echo isset($_POST['translations'][$code]['title']) 
          ? h($_POST['translations'][$code]['title']) 
          : (isset($category) && $category->translations[$code]['title']
          ? h($category->translations[$code]['title']) : '');
      ?>"
    />
  </div>

  <div class="admin-form__field">
    <label class="admin-form__label" for="description-<?php echo $code;?>">
       <?php if ($this->routeData->uriGet) : ?> 
          Описание категории
        <?php else : ?>
          Описание раздела
        <?php endif;?>
    </label>
    <textarea 
      id="description-<?php echo $code;?>" 
      name="translations[<?php echo $code;?>][description]" 
      class="admin-form__textarea" 
      placeholder="Введите описание категории"
    ><?php 
      echo isset($_POST['translations'][$code]['description'])  
      ? h($_POST['translations'][$code]['description'])  
      : (isset($category) && $category->translations[$code]['description'] 
      ? h($category->translations[$code]['description']) : '');
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
        : (isset($category) && $category->translations[$code]['meta_title']
        ? h($category->translations[$code]['meta_title']) : '');
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
      : (isset($category) && $category->translations[$code]['meta_description']
      ? h($category->translations[$code]['meta_description']) : '');
    ?></textarea>
  </div>

</div>
