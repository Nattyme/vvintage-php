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

// Форматируем дату
function rus_date () {
  // Перевод
  $translate = array(
		"am" => "дп",
		"pm" => "пп",
		"AM" => "ДП",
		"PM" => "ПП",
		"Monday" => "Понедельник",
		"Mon" => "Пн",
		"Tuesday" => "Вторник",
		"Tue" => "Вт",
		"Wednesday" => "Среда",
		"Wed" => "Ср",
		"Thursday" => "Четверг",
		"Thu" => "Чт",
		"Friday" => "Пятница",
		"Fri" => "Пт",
		"Saturday" => "Суббота",
		"Sat" => "Сб",
		"Sunday" => "Воскресенье",
		"Sun" => "Вс",
		"January" => "Января",
		"Jan" => "Янв",
		"February" => "Февраля",
		"Feb" => "Фев",
		"March" => "Марта",
		"Mar" => "Мар",
		"April" => "Апреля",
		"Apr" => "Апр",
		"May" => "Мая",
		"May" => "Мая",
		"June" => "Июня",
		"Jun" => "Июн",
		"July" => "Июля",
		"Jul" => "Июл",
		"August" => "Августа",
		"Aug" => "Авг",
		"September" => "Сентября",
		"Sep" => "Сен",
		"October" => "Октября",
		"Oct" => "Окт",
		"November" => "Ноября",
		"Nov" => "Ноя",
		"December" => "Декабря",
		"Dec" => "Дек",
		"st" => "ое",
		"nd" => "ое",
		"rd" => "е",
		"th" => "ое"
  );
  // если передали дату, то переводим её
  if ( func_num_args() > 1 ) {
      return strtr(date(func_get_arg(0), func_get_arg(1)), $translate);
  } 
  // Иначе генерируем текущее время по шаблону
  else {
      return strtr(date(func_get_arg(0)), $translate);
  }
}

// pagination (6, 'posts'); pagination (6, 'posts', [' cat = ? ', [4] ]);
function pagination ($results_per_page, $type, $params = NULL) {
  intval($type);
  if ( empty($params) ) {
    $number_of_results = R::count($type);
  } 

  else {
    $number_of_results = R::count($type, $params[0], $params[1]); // Вернет кол-во постов
  }

  // Считаем кол-во страниц пагинации
  // $number_of_results = R::count($type); // Вернет кол-во постов
  $number_of_pages = ceil($number_of_results / $results_per_page); // ceil округляет число в бол. сторону

  // Определяем текущий номер запрашиваемой страницы 
  if ( !isset($_GET['page']) || empty($_GET['page'])) {
    $page_number = 1;
  } else {
    $page_number = intval($_GET['page']); // 2ая стр. пагинации
  }

  // Если текущий номер страницы больше общего кол-ва страниц - показываем последнюю доступную
  if($page_number > $number_of_pages) {
    $page_number = $number_of_pages;
  }

  // Определяем с какого поста начать вывод
  $starting_limit_number = ($page_number-1) * $results_per_page; // (2-1) * 6 = 6;

  // Формируем подстроку для sql запроса
  $sql_page_limit = "LIMIT {$starting_limit_number}, {$results_per_page}";

  // Результирующий массив с параметрами
  $result['number_of_pages'] = $number_of_pages;
  $result['page_number'] = $page_number;
  $result['sql_page_limit'] =  $sql_page_limit;

  return $result;
}

//breadcrumbs
// function breadcrumbs ($uriModule, $uriGet, $uriGetParam) {

// }

/* **Работа с файлами. Сохранение изображения** */
// saveUploaddedImg("cover", [600, 300], 12, 'blog', [1110, 460], [290, 230]) 
function saveUploadedImg($inputFileName, $minSize, $maxFileSizeMb, $folderName, $fullSize, $smallSize) {
    /* 
      1. Имя файла из формы | string
      2. Мин. размер по ширине , мин. размер по высоте | array
      3. Мах. размер в MB | integer
      4. Название папки для сохран. файла | string
      5. Размеры болшьшой версии изображения | array
      6. Размеры маленькой версии изображени | array 
    */
  if( isset($_FILES[$inputFileName]['name']) && $_FILES[$inputFileName]['tmp_name'] !== '') {
    // 1. Записываем парам-ры файла в переменные
    $fileName = $_FILES[$inputFileName]['name'];
    $fileTmpLoc = $_FILES[$inputFileName]['tmp_name'];
    $fileType = $_FILES[$inputFileName]['type'];
    $fileSize = $_FILES[$inputFileName]['size'];
    $fileErrorMsg = $_FILES[$inputFileName]['error'];
    $kaboom = explode(".", $fileName);
    $fileExt = end($kaboom);

    // 2. Проверка файла на соответствие требованиям сайта к фото
    // 2.1 Проверка на маленький размер изображения
    list($width, $height) = getimagesize($fileTmpLoc);

    if ($width < $minSize[0] || $height < $minSize[1] ) {
      $_SESSION['errors'][] = [
        'title' => 'Изображение слишком маленького размера',
        'desc' => 'Загрузите изображение с размерами от 600x300 и более.'
      ];
    }

    // 2.2 Проверка на большой вес файла изображения
    if ($fileSize > ($maxFileSizeMb * 1024 * 1024)) {
      $_SESSION['errors'][] = [
        'title' => 'Файл изображения не должен быть более 12 Mb'
      ];
    }

    // 2.3 Проверка на формат файла
    if (!preg_match("/\.(gif|jpg|jpeg|png)$/i", $fileName)) {
      $_SESSION['errors'][] = [
        'title'=> 'Недопустимый формат файла',
        'desc'=> '<p>Файл изображения должен быть в формате gif, jpg, jpeg или png.</p>'
      ];
    }

    // 2.4 Проверка на иную ошибку
    if ($fileErrorMsg == 1) {
      $_SESSION['errors'][] = ['title' => 'При загрузке файла произошла ошибка. Повторите попытку.'];
    }

    // Если ошибок нет
    if ( empty($_SESSION['errors']) ) {
      // Прописываем путь для хранения изображения
      $imgFolderLocation = ROOT . "usercontent/{$folderName}/";

      $db_file_name = rand(100000000000,999999999999) . "." . $fileExt;
    
      $filePathFullSize = $imgFolderLocation . $db_file_name;
      $filePathSmallSize = $imgFolderLocation . $smallSize[0] . '-' . $db_file_name;

      // Обработать фотографию
      // 1. Обрезать до мах размера
      $resultFullSize = resize_and_crop($fileTmpLoc, $filePathFullSize, $fullSize[0], $fullSize[1]);
      // 2. Обрезать до мин размера
      $resultSmallSize = resize_and_crop($fileTmpLoc, $filePathSmallSize, $smallSize[0], $smallSize[1]);

      if ($resultFullSize != true || $resultSmallSize != true) {
        $_SESSION['errors'][] = ['title' => 'Ошибка сохранения файла'];
        return false;
      }

      return [$db_file_name, $smallSize[0] . '-' . $db_file_name,];
      
    }
  }
}

  //Проверка, что передан массив изображений

  function reArrayFiles( $file_post) {
    $file_count  = count( $file_post['name']);
    $file_keys  = array_keys($file_post);
    
    $file_ary    = [];    //Итоговый массив
    for($i=0; $i<$file_count; $i++) {
      foreach($file_keys as $key) {
        $file_ary[$i][$key] =  $file_post[$key][$i];  
      }
        
    }
    $reArray = [$file_ary, $file_count];
    return $reArray;
  }

  
  function saveSliderImg($inputFileName, $minSize, $maxFileSizeMb, $folderName, $size, $smallSize) {
    
    $reArray = reArrayFiles($_FILES[$inputFileName]);
    $file_ary = $reArray[0];
    $file_count = $reArray[1];

    $filesAmount = count ($file_ary);
    
    for( $i=0; $i< $file_count; $i++) {
      foreach($file_ary as $key => $value) {
      
        // 1. Записываем парам-ры файла в переменные
        $fileName = $file_ary[$key]['name'];
        $fileTmpLoc = $file_ary[$key]['tmp_name'];
        $fileType = $file_ary[$key]['type'];
        $fileSize = $file_ary[$key]['size'];
        $fileErrorMsg = $file_ary[$key]['error'];
        $kaboom = explode(".", $fileName);
        $fileExt = end($kaboom);

        // 2. Проверка файла на соответствие требованиям сайта к фото
        // 2.1 Проверка на маленький размер изображения
        list($width, $height) = getimagesize($fileTmpLoc);
        
        if ($width < $minSize[0] || $height < $minSize[1] ) {
          $_SESSION['errors'][] = [
            'title' => 'Изображение слишком маленького размера',
            'desc' => 'Загрузите изображение с размерами от 536x566 и более.'
          ];
        }
        
        // 2.2 Проверка на большой вес файла изображения
        if ($fileSize > ($maxFileSizeMb * 1024 * 1024)) {
          $_SESSION['errors'][] = [
            'title' => 'Файл изображения не должен быть более 12 Mb'
          ];
        }
  
        // 2.3 Проверка на формат файла
        if (!preg_match("/\.(gif|jpg|jpeg|png|webp)$/i", $fileName)) {
          $_SESSION['errors'][] = [
            'title'=> 'Недопустимый формат файла',
            'desc'=> '<p>Файл изображения должен быть в формате gif, jpg, jpeg или png.</p>'
          ];
        }

        // 2.4 Проверка на иную ошибку
        if ($fileErrorMsg == 1) {
          $_SESSION['errors'][] = ['title' => 'При загрузке файла произошла ошибка. Повторите попытку.'];
        }
    
        // Если ошибок нет
        if ( empty($_SESSION['errors']) ) {
          // Прописываем путь для хранения изображения
          $imgFolderLocation = ROOT . "usercontent/{$folderName}/";
    
          $db_file_name = rand(100000000000,999999999999) . "." . $fileExt;
          $db_file_full_name = rand(100000000000,999999999999) . "@2x." . $fileExt;
        
          $filePathFullSize = $imgFolderLocation . $db_file_full_name;
          $filePathSize = $imgFolderLocation . $db_file_name;
          $filePathSmallSize = $imgFolderLocation . $smallSize[0] . '-' . $db_file_name;
          
          // Обработать фотографию
          // Сохраняем полный размер изображения
          
          // 1. Обрезать до мах размера
          $resultSize = resize_and_crop($fileTmpLoc, $filePathSize, $size[0], $size[1]);
          // 2. Обрезать до мин размера
          $resultSmallSize = resize_and_crop($fileTmpLoc, $filePathSmallSize, $smallSize[0], $smallSize[1]);

          $resultFullSize = move_uploaded_file($fileTmpLoc, $filePathFullSize);
          
          if ($resultFullSize != true || $resultSize != true || $resultSmallSize != true) {
            $_SESSION['errors'][] = ['title' => 'Ошибка сохранения файла'];
            return false;
          }
          $cover = [$db_file_full_name, $db_file_name, $smallSize[0] . '-' . $db_file_name];
          
          $coverArray[] = $cover;
          
        }
        
      }
      return $coverArray;
    }
  
  }
  

function saveUploadedImgNoCrop ($inputFileName, $minSize, $maxFileSizeMb, $folderName, $fullSize, $smallSize) {
  /*
    1. Имя файла из формы (avatar / cover / project) | string
    2. Минимальный размер изображения по ширине и высоте | array
    3. Максимальный размер файла в Мб | integer
    4. Имя директории для размещения файла | string
    5. Размеры большой версии изображения | array
    6. Размеры маленькой превьюшки | array
  */

  // 1. Записываем параметры файла в переменные
  $fileName = $_FILES[$inputFileName]["name"];
  $fileTmpLoc = $_FILES[$inputFileName]["tmp_name"];
  $fileType = $_FILES[$inputFileName]["type"];
  $fileSize = $_FILES[$inputFileName]["size"];
  $fileErrorMsg = $_FILES[$inputFileName]["error"];
  $kaboom = explode(".", $fileName);
  $fileExt = end($kaboom);

  // 2. Проверка файла на корректность
  // 2.1 Проверка на маленький размер изображения
  list($width, $height) = getimagesize($fileTmpLoc);
  if ($width < $minSize[0] || $height < $minSize[1]) {
      $_SESSION['errors'][] = [
          'title' => 'Изображение слишком маленького размера. ',
          'desc' => 'Загрузите изображение c размерами от 600x300 или более .'
      ];
  }

  // 2.2 Проверка на большой вес файла
  if ($fileSize > ($maxFileSizeMb * 1024 * 1024)) {
      $_SESSION['errors'][] = ['title' => 'Файл изображения не должен быть более 12 Mb'];
  }

  // 2.3 Проверка на формат файла
  if (!preg_match("/\.(gif|jpg|jpeg|png)$/i", $fileName)) {
      $_SESSION['errors'][]  = ['title' => 'Неверный формат файла', 'desc' => '<p>Файл изображения должен быть в формате gif, jpg, jpeg, или png.</p>',];
  }

  // 2.4 Проверка ошибки при загрузке
  if ($fileErrorMsg == 1) {
      $_SESSION['errors'][] = ['title' => 'При загрузке изображения произошла ошибка. Повторите попытку'];
  }

  // Если нет ошибок - двигаемся дальше
  if (empty($_SESSION['errors'])) {

      // Прописываем путь для хранения изображения
      $imgFolderLocation = ROOT . "usercontent/{$folderName}/";

      $db_file_name =
          rand(100000000000, 999999999999) . "." . $fileExt;
      $filePathFullSize = $imgFolderLocation . $db_file_name;
      $filePathSmallSize = $imgFolderLocation . $smallSize[0] . '-' . $db_file_name;

      // Обработать фотографию
      // 1. Обрезать до 160х160
      $resultFullSize = resize_no_crop($fileTmpLoc, $filePathFullSize, $fullSize[0], $fullSize[1]);
      // 2. Обрезать до 48х48
      $resultSmallSize = resize_no_crop($fileTmpLoc, $filePathSmallSize, $smallSize[0], $smallSize[1]);

      if ($resultFullSize != true || $resultSmallSize != true) {
          $_SESSION['errors'][] = ['title' => 'Ошибка сохранения файла'];
          return false;
      }

      return [$db_file_name, $smallSize[0] . '-' . $db_file_name];
  }
 }



// saveUploadedFile("file", 12, 'contact-form') 
function saveUploadedFile($inputFileName, $maxFileSizeMb, $folderName) {
  if( isset($_FILES[$inputFileName]['name']) && $_FILES[$inputFileName]['tmp_name'] !== '') {
    // 1. Записываем парам-ры файла в переменные
    $fileName = $_FILES[$inputFileName]['name'];
    $fileTmpLoc = $_FILES[$inputFileName]['tmp_name'];
    $fileType = $_FILES[$inputFileName]['type'];
    $fileSize = $_FILES[$inputFileName]['size'];
    $fileErrorMsg = $_FILES[$inputFileName]['error'];
    $kaboom = explode(".", $fileName);
    $fileExt = end($kaboom);

    // 2. Проверка файла на соответствие требованиям сайта к фото
    // 2.1 Проверка на большой вес файла изображения
    if ($fileSize > ($maxFileSizeMb * 1024 * 1024)) {
      $_SESSION['errors'][] = [
        'title' => 'Файл изображения не должен быть более 12 Mb'
      ];
    }

    // 2.2 Проверка на формат файла
    if (!preg_match("/\.(gif|jpg|jpeg|png|pdf|zip|rar|doc|docx|svg)$/i", $fileName)) {
      $_SESSION['errors'][] = [
        'title'=> 'Недопустимый формат файла',
        'desc'=> '<p>Файл должен быть в формате gif, jpg, jpeg,png, pdf, zip, rar, doc или docx</p>'
      ];
    }

    // 2.3 Проверка на иную ошибку
    if ($fileErrorMsg == 1) {
      $_SESSION['errors'][] = ['title' => 'При загрузке файла произошла ошибка. Повторите попытку.'];
    }

    // Если ошибок нет
    if ( empty($_SESSION['errors']) ) {
      // Прописываем путь для хранения изображения
      $fileFolderLocation = ROOT . "usercontent/{$folderName}/";

      $db_file_name = rand(100000000000,999999999999) . "." . $fileExt;
      $newFilePath = $fileFolderLocation . $db_file_name;

      // Перемещаем загруженный файл
      $result = move_uploaded_file($fileTmpLoc, $newFilePath);

      if ($result != true) {
        $_SESSION['errors'][] = ['title' => 'Ошибка сохранения файла'];
        return false;
      }

      return [$db_file_name, $fileName];
    }
  }
}

function num_decline( $number, $titles, $show_number = false ){

	if( is_string( $titles ) ){
		$titles = preg_split( '/, */', $titles );
	}

	// когда указано 2 элемента
	if( empty( $titles[2] ) ){
		$titles[2] = $titles[1];
	}

	$cases = [ 2, 0, 1, 1, 1, 2 ];

	$intnum = abs( (int) strip_tags( $number ) );

	$title_index = ( $intnum % 100 > 4 && $intnum % 100 < 20 )
		? 2
		: $cases[ min( $intnum % 10, 5 ) ];

	return ( $show_number ? "$number " : '' ) . $titles[ $title_index ];
}

// Вывод похожих постов
function get_related_posts ($postTitle) {
  // Разбиваем заголовок на слова, записваем массив в переменую
  $wordsArray = explode(' ', $postTitle);
  $wordsArray = array_unique($wordsArray);

  // Массив со стоп словами (предлоги, союзы, и др. "общие" слова)
  $stopWords = ['и', 'на', 'в', 'а', 'под', 'если', 'за', 'что', '-', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

  // Новый обработанный массив
  $newWordsArray = array();
  foreach ($wordsArray as $word) {
    // Перевод в нижний регистр
    $word = mb_strtolower($word);

    // Удаление кавычек и лишних символов
    $word = str_replace('"', "", $word);
    $word = str_replace("'", "", $word);
    $word = str_replace('«', "", $word);
    $word = str_replace('»', "", $word);
    $word = str_replace(',', "", $word);
    $word = str_replace('.', "", $word);
    $word = str_replace(':', "", $word);
    $word = str_replace('(', "", $word);
    $word = str_replace(')', "", $word);

    // Проверка наличия слова в стоп списке
    if ( !in_array($word, $stopWords) ) {

      // Обрезаем окончания
      if (mb_strlen($word) > 4 ) {
        $word = mb_substr($word, 0, -2);
      } else if (mb_strlen($word) > 3) {
        $word = mb_substr($word, 0, -1);
      }

      // Добавляем символ шаблона
      $word = '%' . $word . '%';

      // Добавляем слова в новыц массив
      $newWordsArray[] = $word;
    }
  }

  // Фрмируем sql запрос
  $sqlQuery = 'SELECT id, title, cover_small FROM `posts` WHERE ';

  for ($i = 0; $i < count($newWordsArray); $i++) {
    if ($i + 1 == count($newWordsArray)) {
      // Последний цикл
      $sqlQuery .= 'title LIKE ?';
    } else {
      $sqlQuery .= 'title LIKE ? OR ';
    }
  }

  $sqlQuery .= 'order by RAND() LIMIT 3';
  return R::getAll($sqlQuery, $newWordsArray);
};

// Вывод похожих продуктов
function get_related_products ($productTitle) {
  // Разбиваем заголовок на слова, записваем массив в переменую
  $wordsArray = explode(' ', $productTitle);
  $wordsArray = array_unique($wordsArray);

  // Массив со стоп словами (предлоги, союзы, и др. "общие" слова)
  $stopWords = ['и', 'на', 'в', 'а', 'под', 'если', 'за', 'что', '-', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

  // Новый обработанный массив
  $newWordsArray = array();
  foreach ($wordsArray as $word) {
    // Перевод в нижний регистр
    $word = mb_strtolower($word);

    // Удаление кавычек и лишних символов
    $word = str_replace('"', "", $word);
    $word = str_replace("'", "", $word);
    $word = str_replace('«', "", $word);
    $word = str_replace('»', "", $word);
    $word = str_replace(',', "", $word);
    $word = str_replace('.', "", $word);
    $word = str_replace(':', "", $word);
    $word = str_replace('(', "", $word);
    $word = str_replace(')', "", $word);

    // Проверка наличия слова в стоп списке
    if ( !in_array($word, $stopWords) ) {

      // Обрезаем окончания
      if (mb_strlen($word) > 4 ) {
        $word = mb_substr($word, 0, -2);
      } else if (mb_strlen($word) > 3) {
        $word = mb_substr($word, 0, -1);
      }

      // Добавляем символ шаблона
      $word = '%' . $word . '%';

      // Добавляем слова в новыц массив
      $newWordsArray[] = $word;
    }
  }

  // Фрмируем sql запрос
  $sqlQuery = 'SELECT id, title, price, cover_small FROM `products` WHERE ';

  for ($i = 0; $i < count($newWordsArray); $i++) {
    if ($i + 1 == count($newWordsArray)) {
      // Последний цикл
      $sqlQuery .= 'title LIKE ?';
    } else {
      $sqlQuery .= 'title LIKE ? OR ';
    }
  }

  $sqlQuery .= 'order by RAND() LIMIT 3';
  return R::getAll($sqlQuery, $newWordsArray);
};

// Проверка вошел ли пользователь в профиль (залогинился)
function isLoggedIn() {
  $result = false;

  if ( isset($_SESSION['logged_user']) ) {
    $result = true;
  }

  return $result;
}

function format_price ($price) {
  return number_format($price, 0, ',', ' ');
}

function isFav_list ($productId) {
  $result = false;
  if (isset($_COOKIE['fav_list']) && !empty($_COOKIE['fav_list'])) {
    // Получаем избранные товары из COOKIE
    $fav_list = json_decode($_COOKIE['fav_list'], true);
    if (isset($fav_list[$productId])) {
      $result = true;
    }
  } else if (isset($_SESSION['fav_list']) && !empty($_SESSION['fav_list'])) {
    // Получаем избранные товары из сессии
    $fav_list = $_SESSION['fav_list'];
    if (isset($fav_list[$productId])) {
      $result = true;
    }
  }
  return $result;
}


















