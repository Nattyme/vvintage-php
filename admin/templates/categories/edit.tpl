<div class="admin-page__content-form">
  
  <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
  <?php include ROOT . "admin/templates/components/success.tpl"; ?>

  <form 
      id="form-edit-category" 
      method="POST" 
      action="<?php echo HOST;?>admin/category-edit?id=<?php echo u($_GET['id']);?>"
      class="admin-form">

      <div class="admin-form__field">
        <label class="admin-form__label" for="title">Название категории</label>
        <input 
          id="title"
          name="title" 
          class="admin-form__input admin-form__input--width-label" 
          type="text" 
          placeholder="Введите заголовок категории" 
          value="<?php echo h(trim($cat['title']));?>"
          required
        />
      </div>

      <!-- CSRF-токен -->
      <input type="hidden" name="csrf" value="<?php echo h(csrf_token()) ;?>">

      <div class="admin-form__buttons buttons">
        <!-- <a class="button button-outline button-outline--admin" href="<?php echo HOST;?>shop">Отмена</a> -->
        <?php if (isset($_POST['submit'])) : ?>
          <a class="button button-solid" href="<?php echo HOST;?>admin/category" title="К списку категорий">К списку товаров</a>
        <?php else : ?>
          <a class="button button-outline button-outline--admin" href="<?php echo HOST;?>admin/category" title="Отмена">Отмена</a>
        <?php endif; ?>
        <button class="button button-solid" type="submit" name="submit" value="submit">Сохранить</button>
      </div>
  </form>

</div>

