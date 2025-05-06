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
          <h2><span>VVintage</span> Панель управления:</h2>
        </div>
      </header>
      <div class="dashboard__content" id="dashboard__content">
        <?php echo $content; ?>
      </div>

    </div>
  </div>
</div>
<?php include ROOT . 'admin/templates/_parts/_foot.tpl';
