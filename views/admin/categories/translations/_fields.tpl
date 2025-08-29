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
      name="title[<?php echo $code;?>]" 
      class="admin-form__input" 
      type="text" 
      placeholder="Введите название категории" 
      value="<?php 
          echo isset($_POST['title'][$code]) 
          ? h($_POST['title'][$code] ) 
          : (isset($category) && $category->getTranslatedTitle() ? h($category->getTranslatedTitle()) : '');
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
      name="description[<?php echo $code;?>]" 
      class="admin-form__textarea" 
      placeholder="Введите описание категории"
    ><?php 
      echo isset($_POST['description'][$code]) 
      ? h($_POST['title'][$code] ) 
      : (isset($category) && $category->getTranslatedDescription($code) 
      ? h($category->getTranslatedDescription($code)) : '');
    ?></textarea>
  </div>


  <div class="admin-form__field">
    <label class="admin-form__label" for="meta_title-<?php echo $code;?>">SEO заголовок страницы</label>
    <input 
      id="meta_title-<?php echo $code;?>" 
      name="meta_title[<?php echo $code;?>]" 
      class="admin-form__input" 
      type="text" 
      placeholder="Введите SEO заголовок страницы" 
      value="<?php 
        echo isset($_POST['meta_title'][$code]) 
        ? h($_POST['meta_title'][$code] ) 
        : (isset($category) && $category->getSeoTitle() ? h($category->getSeoTitle()) : '');
      ?>"
    />
  </div>

  <div class="admin-form__field">
    <label class="admin-form__label" for="meta_description-<?php echo $code;?>">SEO описание страницы</label>
    <textarea 
      id="meta_description-<?php echo $code;?>" 
      name="meta_description[<?php echo $code;?>]" 
      class="admin-form__textarea" 
      placeholder="Введите SEO описание страницы"
    ><?php 
      echo isset($_POST['meta_description'][$code]) 
      ? h($_POST['meta_description'][$code] ) 
      : (isset($category) && $category->getSeoDescription($code) 
      ? h($category->getSeoDescription($code)) : '');
    ?></textarea>
  </div>
</div>
