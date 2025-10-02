<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
  <title><?php echo (isset($seo) && method_exists($seo, 'getTitle')) ? h($seo->getTitle()) : ''; ?></title>

  <link rel="icon" type="image/x-icon" href="<?php echo HOST . 'static/img/favicons/favicon.svg'; ?>" />
  <link rel="apple-touch-icon" sizes="180x180" href="<?php echo HOST . 'static/img/favicons/apple-touch-icon.png'; ?>" />
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
  <link rel="stylesheet" href="<?php echo HOST . 'static/css/main.css'; ?>" />

  <?php 
    if ($routeData->uriModule === '' || $routeData->uriModule === 'contacts') {
      echo '<script src="https://api-maps.yandex.ru/v3/?apikey=144f79d1-953e-448c-9341-fb93fa71b6c2&lang=ru_RU"></script>';
    } 
  ?>

  <!-- SEO: description -->
  <meta name="description" content="<?php echo (isset($seo) && method_exists($seo, 'getDescription')) ? h($seo->getDescription()) : ''; ?>">

  <!-- Canonical -->
  <link rel="canonical" href="<?php echo h(HOST . ltrim($_SERVER['REQUEST_URI'], '/')); ?>">

  <!-- Meta language -->
  <meta name="language" content="<?php echo h($currentLang ?? 'ru'); ?>">

  <!-- Open Graph -->
  <meta property="og:title" content="<?php echo (isset($seo) && method_exists($seo, 'getTitle')) ? h($seo->getTitle()) : ''; ?>">
  <meta property="og:description" content="<?php echo (isset($seo) && method_exists($seo, 'getDescription')) ? h($seo->getDescription()) : ''; ?>">
  <meta property="og:type" content="website">

  <!-- Twitter Meta (если понадобится) -->
  <!-- 
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?php echo h($pageTitle ?? ''); ?>">
  <meta name="twitter:description" content="<?php echo h($pageDescription ?? ''); ?>">
  <meta name="twitter:image" content="<?php echo h($ogImage ?? HOST . 'static/img/default-og.png'); ?>">
  -->
  <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
</head>

<?php if (isset($pageClass) && $pageClass === 'authorization-page'): ?> 
<body class="authorization-page animated-bg-lines">
<?php else: ?>
<body class="sticky-footer main-page body-with-panel <?php echo isset($pageClass) ? h($pageClass) : ''; ?>">
<?php endif; ?>
