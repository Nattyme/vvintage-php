<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title><?php echo h($pageTitle); ?></title>
    <link rel="icon" type="image/x-icon" href="<?php echo HOST . 'static/img/favicons/favicon.svg';?>" />
		<link rel="apple-touch-icon" sizes="180x180" href="<?php echo HOST . 'static/img/favicons/apple-touch-icon.png';?>" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"
    />
    <link rel="stylesheet" href="<?php echo HOST . 'static/css/main.css';?>"/>

    <?php 
      if ($uriModule === '' || $uriModule === 'contacts') {
        echo '<script src="https://api-maps.yandex.ru/v3/?apikey=144f79d1-953e-448c-9341-fb93fa71b6c2&lang=ru_RU"></script>';
      } else {
        echo '';
      } 
    ?> 
   
	</head>

 
  <?php if ( isset($pageClass) && $pageClass === 'authorization-page') : ?> 
  <body class="authorization-page">
  <?php else : ?>
  <body class="sticky-footer main-page body-with-panel <?php echo isset($pageClass) ? h($pageClass) : ''; ?>">
  <?php endif;
  