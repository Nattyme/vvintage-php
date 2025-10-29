<!DOCTYPE html>
<html lang="<?php echo (isset($seo) && !empty($seo->currentLang)) ? h($seo->currentLang) : 'ru'; ?>">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo (isset($seo) && !empty($seo->meta_title)) ? h($seo->meta_title) : ''; ?></title>

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
  <meta name="description" content="<?php echo (isset($seo) && !empty($seo->meta_description)) ? h($seo->meta_description) : ''; ?>">

  <!-- robots -->
  <meta name="robots" content="<?php echo (isset($seo) && !empty($seo->isIndexed)) ? h($seo->isIndexed) : ''; ?>">

  <!-- Canonical -->
  <link rel="canonical" href="<?php echo h(HOST . ltrim($_SERVER['REQUEST_URI'], '/')); ?>">

  <!-- Open Graph -->
  <meta property="og:title" content="<?php echo (isset($seo) && !empty($seo->title)) ? h($seo->title) : ''; ?>">
  <meta property="og:description" content="<?php echo (isset($seo) && !empty($seo->description)) ? h($seo->description) : ''; ?>">
  <meta property="og:type" content="website">
  <meta property="og:image" content="<?php echo (isset($seo) && !empty($seo->ogImg)) ? h($seo->ogImg) : HOST . 'static/img/default-og.png'; ?>">

  <meta property="og:locale" content="<?php echo (isset($seo) && !empty($seo->currentLang)) ? h($seo->currentLang) : 'ru'; ?>">

  <!-- Twitter Meta (если понадобится) -->
  <!-- 
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?php echo h($pageTitle ?? ''); ?>">
  <meta name="twitter:description" content="<?php echo h($pageDescription ?? ''); ?>">
  <meta name="twitter:image" content="<?php echo h($ogImage ?? HOST . 'static/img/default-og.png'); ?>">
  -->
  <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
  <?php echo $seo->structuredData ?? ''; ?>
</head>

<!-- Определяем странцы и записываем в data для JS -->
<?php 

  if($routeData->isAdmin) {
    $zone = 'admin';
    $page = $routeData->uriModule ?: 'main';
    $itemId = $routeData->uriGet ?: null;
  } else 
  {
    $zone = 'front';
    $page = $routeData->uriModule ?: 'main';
    $itemId = $routeData->uriGet ?: null;
    
    if(is_string($routeData->uriGet)) {
      $page = $page . '/' . $routeData->uriGet;
    } else if ($routeData->uriGetParams) {
      $page = $page . '/' . $routeData->uriGet;
      $itemId = $routeData->uriGetParams[0] ?: null;
    }
    
  }
?>
<?php if (isset($pageClass) && $pageClass === 'authorization-page'): ?> 
  <body class="authorization-page animated-bg-lines" data-page="<?php echo h($page); ?>" data-zone="<?php echo h($zone); ?>">
<?php else: ?>
  <body class="sticky-footer main-page body-with-panel <?php echo isset($pageClass) ? h($pageClass) : ''; ?>" 
        data-page="<?php echo h($page); ?>" data-zone="<?php echo h($zone); ?>"
      <?php if(!empty($itemId)) : ?>
        data-id="<?php echo h($itemId); ?>"
      <?php endif; ?>
  >
<?php endif; ?>
