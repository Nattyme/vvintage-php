<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title><?php echo $pageTitle; ?></title>
    <!-- <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    /> -->
    <link rel="stylesheet" href="<?php echo HOST . 'static/css/main.css';?>"/>


		<link rel="icon" type="image/x-icon" href="./img/favicons/favicon.svg" />
		<link rel="apple-touch-icon" sizes="180x180" href="./img/favicons/apple-touch-icon.png" />
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
  <body class="sticky-footer <?php echo isset($pageClass) ? $pageClass : ''; ?>">
  <?php endif;