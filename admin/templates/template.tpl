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
          <h2><span>VVintage</span> Панель управления</h2>
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
  <a href="#top" class="backtop-btn" id="backtop" style="opacity: 1;" title="Наверх">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"> 
      <path d="M214.6 41.4c-12.5-12.5-32.8-12.5-45.3 0l-160 160c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 141.2V448c0 17.7 14.3 32 32 32s32-14.3 32-32V141.2L329.4 246.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-160-160z"/>
    </svg>
  </a>
  <!--// backtop button -->
</div>
<?php include ROOT . 'admin/templates/_parts/_foot.tpl';
