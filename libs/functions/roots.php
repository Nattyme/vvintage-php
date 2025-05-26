<?php 
  // Поиск названия модуля
  function getModuleName () {
    $uri = $_SERVER['REQUEST_URI'];
    $uriArr = explode('?', $uri); // Разбиваем запрос по сиволу '?', чтобы отсечь GET запрос
    $uri = $uriArr[0]; //  /admin/blog?id=15 => /admin/blog
    $uri = rtrim($uri, "/"); // Обрезаем сивол '/' в конце /admin/blog/ => /admin/blog
    $uri = substr($uri, 1); //Удаляем первый символ (слэш) в запросе admin/blog
    $uri = filter_var($uri, FILTER_SANITIZE_URL); // Удалем лишние сиволы из запроса

    // Еще раз разбиваем строку запроса по символу "/",  получаем массив 
    $moduleNameArr = explode('/', $uri); // admin/blog => ['admin, 'blog']
    $uriModule = $moduleNameArr[0]; // Достаем имя модуля кот нужно запустить  admin/blog => blog
    return $uriModule; // blog Какой модуль запускаем
  }

  // Поиск названия модуля для Админки 
  function getModuleNameForAdmin() {
    $uri = $_SERVER['REQUEST_URI'];
    $uriArr = explode('?', $uri); // Разбиваем запрос по сиволу '?', чтобы отсечь GET запрос
    $uri = $uriArr[0]; //  /admin/blog?id=15 => /admin/blog
    $uri = rtrim($uri, "/"); // Обрезаем сивол '/' в конце /admin/blog/ => /admin/blog
    $uri = substr($uri, 1); //Удаляем первый символ (слэш) в запросе admin/blog
    $uri = filter_var($uri, FILTER_SANITIZE_URL); // Удалем лишние сиволы из запроса

    // Еще раз разбиваем строку запроса по символу "/",  получаем массив 
    // admin/blog => ['admin, 'blog']
    $moduleNameArr = explode('/', $uri);
    $uriModule = isset($moduleNameArr[1]) ? $moduleNameArr[1] : null; // Достаем имя модуля кот нужно запустить  admin/blog => blog
    return $uriModule; // blog Какой модуль запускаем
  }

  // Аналог get запроса из URI
  function getUriGet () {
    $uri = $_SERVER['REQUEST_URI'];
    $uri = rtrim($uri, "/"); // Удаляем сивол / в конце строки
    $uri = filter_var($uri, FILTER_SANITIZE_URL); // Удалем лишние сиволы из запроса
    $uri = substr($uri, 1); //Удаляем первый символ (слэш) в запросе
    $uri = explode('?', $uri);
    $uri = $uri[0];
    $uriArr = explode('/', $uri);
    $uriGet = isset($uriArr[1]) ? $uriArr[1] : null; 
    return $uriGet;
  }

  function getUriGetParam () {
    $uri = $_SERVER['REQUEST_URI'];
    $uri = rtrim($uri, "/"); // Удаляем сивол / в конце строки 'site.ru/' => 'site.ru'
    $uri = filter_var($uri, FILTER_SANITIZE_URL); // Удалем лишние сиволы из запроса
    $uri = substr($uri, 1); //Удаляем первый символ (слэш) в запросе
    $uri = explode('?', $uri); // ['blog/cat/5', 'id=20']
    $uri = $uri[0];// ['blog/cat/5']
    $uriArr = explode('/', $uri); // ['blog', 'cat', '5']
    if ( isset($uriArr[2]) && !is_string($uriArr[2])) {
      intval($uriArr[2]);
    } else if (isset($uriArr[2]) && is_string($uriArr[2])) {
      $uriGet = $uriArr[2];
    } else {
      $uriGet = NULL;
    }
    // $uriGet = isset($uriArr[2]) ? $uriArr[2] : null; 
    return $uriGet; // ['blog/cat/5'] => 5
  }

  // Определение текущей категории
  function getCurrentSection () {
    $uri = $_SERVER['REQUEST_URI'];
    $uriArr = explode('?', $uri); // Разбиваем запрос по сиволу '?', чтобы получить GET запрос
    $uri = isset($uriArr[1]) ? $uriArr[1] : trim($uriArr[0], "/");
    $currentSection = $uri;
    return $currentSection;
  }
