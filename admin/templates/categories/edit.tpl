<div class="admin-page__content-form">
  
  <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
  <?php include ROOT . "admin/templates/components/success.tpl"; ?>

  <form 
      id="form-edit-category" 
      method="POST" 
      action="<?php echo HOST;?>admin/category-edit?id=<?php echo $_GET['id'];?>"
      class="admin-form">

      <div class="form__row">
        <div class="form__column">
          <div class="form__field">
            <label class="form__item">
              <span class="form__text">Название</span>
              <input name="title" class="form__input input" type="text"
                     value="<?php echo $cat['title'];?>"
                     placeholder="Введите название категории" required
              />
            </label>
          </div>
        </div>

      </div>

      <div class="form__button-wrapper form__button-row">
        <!-- <a class="button button-outline button-outline--admin" href="<?php echo HOST;?>shop">Отмена</a> -->
        <?php if (isset($_POST['submit'])) : ?>
          <a class="form__button button-solid" href="<?php echo HOST;?>admin/category" title="К списку категорий">К списку товаров</a>
        <?php else : ?>
          <a class="button button-outline button-outline--admin" href="<?php echo HOST;?>admin/category" title="Отмена">Отмена</a>
        <?php endif; ?>
        <button class="form__button button-solid" type="submit" name="submit" value="submit">Сохранить</button>
      </div>
  </form>

</div>

