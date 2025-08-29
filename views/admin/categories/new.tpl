<div class="admin-page__content-form">
  
  <?php include ROOT . "views/components/errors.tpl"; ?>
  <?php include ROOT . "views/components/success.tpl"; ?>
 
    <?php if ($uriGet) : ?>
        <form class="admin-form" action="<?php echo HOST;?>admin/category-new/<?php echo $uriGet; ?>" method="POST" >
    <?php else : ?>
        <form class="admin-form" action="<?php echo HOST;?>admin/category-new" method="POST">
    <?php endif; ?>

          <?php if ($uriGet) : ?> 
          <div class="admin-form__field">
            <label class="admin-form__label" for="title">
              <?php echo h($currentMainCategory->getTitle());?>
            </label>
            <input 
              id="parent" 
              name="parent_id" 
              class="admin-form__input admin-form__input--width-label" 
              type="text" 
              value="<?php echo h($currentMainCategory->getId());?>"
              hidden
            />
            
      
          </div>
          <?php endif; ?> 
          
          <div class="admin-form__field">
            <label class="admin-form__label" for="title">
              <?php if ($uriGet) : ?> 
                Введите название категории
              <?php else : ?>
                Введите название раздела
              <?php endif;?>
            </label>
            <input 
              id="title" 
              name="title" 
              class="admin-form__input admin-form__input--width-label" 
              type="text" 
              placeholder="Заголовок категории"
              value="<?php echo isset($_POST['title']) ? h($_POST['title']) : '';?>"
              required
            />
            
      
          </div>

          <!-- CSRF-токен -->
          <input type="hidden" name="csrf" value="<?php echo h(csrf_token()) ;?>">

          <div class="admin-form__buttons buttons">
            <button name="submit" value="submit" class="button button--m button--primary" type="submit">
              Создать
            </button>
            <a class="button button--m button--outline" href="<?php echo HOST . 'admin/category';?>">Отмена</a>
          </div>
  </form>
</div>

