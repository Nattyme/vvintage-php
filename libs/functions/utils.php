<?php 
  // pagination (6, 'posts'); pagination (6, 'posts', [' cat = ? ', [4] ]);
  function pagination ($results_per_page, $type, $params = NULL) {
    intval($type);

    // Если передали 0
    if ($results_per_page < 1) {
      $results_per_page = 5; 
    }

    if ( empty($params) ) {
      $number_of_results = R::count($type);
    } else {
      $number_of_results = R::count($type, $params[0], $params[1]); // Вернет кол-во постов
    }

    // Считаем кол-во страниц пагинации
    // $number_of_results = R::count($type); // Вернет кол-во постов
    $number_of_pages = ceil($number_of_results / $results_per_page); // ceil округляет число в бол. сторону

    // Определяем текущий номер запрашиваемой страницы 
    $page_number = isset($_GET['page']) ? intval($_GET['page']) : 1;
    if ($page_number < 1) {
      $page_number = 1;
    }
    // if ( !isset($_GET['page']) || empty($_GET['page'])) {
    //   $page_number = 1;
    // } else {
    //   $page_number = intval($_GET['page']); // 2ая стр. пагинации
    // }

    // Если текущий номер страницы больше общего кол-ва страниц - показываем последнюю доступную
    // if($page_number > $number_of_pages) {
    //   $page_number = $number_of_pages;
    // }
    if ($page_number > $number_of_pages) {
      $page_number = $number_of_pages > 0 ? $number_of_pages : 1;
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

  // Проверка вошел ли пользователь в профиль (залогинился)
  function isLoggedIn() {
    $result = false;

    if ( isset($_SESSION['logged_user']) ) {
      $result = true;
    }

    return $result;
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


