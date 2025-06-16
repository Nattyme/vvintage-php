<?php include ROOT . 'admin/templates/_parts/_head.tpl'; ?>
<div class="admin-page__panel-wrapper">

  <aside class="admin-page__sidebar fancy-scrollbar">
    <?php include ROOT . 'admin/templates/sidebar/sidebar.tpl'; ?>
  </aside>

  <div class="admin-page__content">
    <div class="dashboard" data-config="<?php echo HOST;?>">
  
      <header class="dashboard__header">
        <div class="dashboard-title dashboard__title--wrapper">
          <span class="h3"><?php echo $pageTitle;?></span>
          <!-- <h2><span>VVintage</span> Панель управления</h2> -->
        </div>
      </header>
      <div class="dashboard__content" id="dashboard__content">
        <div class="dashboard__container">
          <?php echo $content; ?>
        </div>
      </div>

    </div>
  </div>

  <!-- backtop button -->
  <a href="#top" class="button button--backtop" id="backtop" title="Наверх">
    <svg class="icon icon--arrow">
      <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#arrow';?>"></use>
    </svg>
  </a>
  <!--// backtop button -->
</div>
<?php include ROOT . 'admin/templates/_parts/_foot.tpl';
