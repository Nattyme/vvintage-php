<?php 
  // Подключаем readbean
  use RedBeanPHP\R; 

  $messages = R::find('messages', 'ORDER BY id DESC'); 
;?>
<section class="sidebar" id="sidebar-tab">

    <div class="sidebar__container sidebar__content">
      <a href="<?php echo HOST;?>" class="control-panel__title-wrapper" title="Перейти на главную страницу сайта" title="Перейти на главную страницу сайта">

        <div class="sidebar__header">
          <div class="sidebar__title-wrapper">
            <h2 class="sidebar__title">VVintage</h2>
          </div>
  
          <p class="sidebar__subtitle">панель управления</p>
        </div>
      
      </a>
      <ul class="sidebar__list" id="sidebar">
        <?php include ROOT . "admin/templates/sidebar/links/_stats.tpl";?>
        <?php include ROOT . "admin/templates/sidebar/links/_shop.tpl";?> 
        <?php include ROOT . "admin/templates/sidebar/links/_orders.tpl";?> 
        <?php include ROOT . "admin/templates/sidebar/links/_messages.tpl";?>
        <?php include ROOT . "admin/templates/sidebar/links/_blog.tpl";?>
        <?php include ROOT . "admin/templates/sidebar/links/_settings.tpl";?>
        <?php include ROOT . "admin/templates/sidebar/links/_pages.tpl";?>
        <?php include ROOT . "admin/templates/sidebar/links/_profile.tpl";?>
        <?php include ROOT . "admin/templates/sidebar/links/_exit.tpl";?>
      </ul>
    </div>





</section>
