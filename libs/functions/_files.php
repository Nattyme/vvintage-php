<?php
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
    $coverArray = [];

    for ($i = 0; $i < $file_count; $i++) {
        $file = $file_ary[$i];
        $fileName = $file['name'];
        $fileTmpLoc = $file['tmp_name'];
        $fileType = $file['type'];
        $fileSize = $file['size'];
        $fileErrorMsg = $file['error'];
        $kaboom = explode(".", $fileName);
        $fileExt = end($kaboom);
        
        $hasError = false;

        // Проверки
        list($width, $height) = getimagesize($fileTmpLoc);
        if ($width < $minSize[0] || $height < $minSize[1]) {
            $_SESSION['errors'][] = [
              'title' => 'Изображение слишком маленького размера', 
              'fileName' => $fileName
            ];
            $hasError = true;
        }

        if ($fileSize > ($maxFileSizeMb * 1024 * 1024)) {
            $_SESSION['errors'][] = [
              'title' => 'Файл слишком большой',
              'fileName' => $fileName
            ];
            $hasError = true;
        }

        if (!preg_match("/\.(gif|jpg|jpeg|png|webp)$/i", $fileName)) {
            $_SESSION['errors'][] = [
              'title' => 'Недопустимый формат файла',
              'fileName' => $fileName
            ];
            $hasError = true;
        }

        if ($fileErrorMsg == 1) {
            $_SESSION['errors'][] = [
              'title' => 'Ошибка при загрузке файла',
              'fileName' => $fileName
            ];
            $hasError = true;
        }

        if ($hasError) {
            continue; // пропускаем текущий файл
        }

        // Генерация имён и путей
        $imgFolderLocation = ROOT . "usercontent/{$folderName}/";
        $db_file_name = rand(100000000000, 999999999999) . "." . $fileExt;
        $db_file_full_name =  $db_file_name . "@2x." . $fileExt;
        $filePathFullSize = $imgFolderLocation . $db_file_full_name;
        $filePathSize = $imgFolderLocation . $db_file_name;
        $filePathSmallSize = $imgFolderLocation . $smallSize[0] . '-' . $db_file_name;
        $orderValue = $_POST['order'][$i] ?? $i;

        // Обработка изображений
        $resultSize = resize_and_crop($fileTmpLoc, $filePathSize, $size[0], $size[1]);
        $resultSmallSize = resize_and_crop($fileTmpLoc, $filePathSmallSize, $smallSize[0], $smallSize[1]);
        $resultFullSize = move_uploaded_file($fileTmpLoc, $filePathFullSize);

        if (!$resultSize || !$resultSmallSize || !$resultFullSize) {
            $_SESSION['errors'][] = [
              'title' => 'Ошибка при сохранении изображения',
              'fileName' => $fileName
            ];
            continue;
        }

        $coverArray[] = [
            'cover_full' => $db_file_full_name,
            'cover' => $db_file_name,
            'cover_small' => $smallSize[0] . '-' . $db_file_name,
            'order' => $orderValue
        ];
    }

    return $coverArray;
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
