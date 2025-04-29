<div class="admin-page__content-form">
  
  <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
  <?php include ROOT . "admin/templates/components/success.tpl"; ?>

  <form class="admin-form" method="POST" action="<?php echo HOST;?>admin/category-edit?id=<?php echo $_GET['id'];?>">
    <div class="admin-form__item admin-form__title">
      <h2 class="heading">Редактировать категорию</h2>
    </div>

    <div class="admin-form__item">
      <label class="admin-form__label">
        Название категории
        <input 
          name="title" 
          class="admin-form__input admin-form__input--width-label" 
          type="text" 
          placeholder="Заголовок категории" 
          value="<?php echo $cat['title'];?>"
        />
      </label>
    </div>

    <div class="admin-form__item admin-form__item--buttons">
      <button name="submit" value="submit" class="button-solid button-solid--admin" type="submit">
        Сохранить изменения
      </button>
        <a class="button-outline button-outline--admin" href="<?php echo HOST;?>admin/category" title="К списку категорий">К списку категорий</a>
    </div>
  </form>
</div>

