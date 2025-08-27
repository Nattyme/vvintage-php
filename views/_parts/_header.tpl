<header class="<?php echo (isset($_SESSION['login']) && $_SESSION['login'] === 1) ? 'header header--with-admin-panel' : 'header'; ?>">
    <?php
      if ($isAdminLoggedIn) {
        include ROOT . "views/_parts/_admin-panel.tpl";
      }
    ?>

  <!-- Верхняя служебная панель -->
  <?php include ROOT . 'views/_parts/_parts-header/_header-top-panel.tpl';?>

  <!-- Основной хедер -->
  <?php include ROOT . 'views/_parts/_parts-header/_header-main-panel.tpl';?>

  <!-- Категории -->
  <?php if (!$isBlogPage) : ?>
    <?php include ROOT . 'views/_parts/_parts-header/_header-nav.tpl';?>
  <?php endif; ?>
</header>

