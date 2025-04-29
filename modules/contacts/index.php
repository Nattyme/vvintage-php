<?php
// print_r($_POST);
// die();
// $settingsContacts = R::find('settings', ' section LIKE ? ', ['contacts']); // Получаем массив с нужными настройками

// $contacts = []; // Создаем массив кот. наполним

// foreach ($settingsContacts as $key => $value) {
//   $contacts[$value['name']] = $value['value'];
// }

if (isset($_POST['submit'])) {
// Проверка если все поля пустые
  if  ( empty(trim($_POST['name'])) &&
        empty(trim($_POST['email'])) &&
        empty(trim($_POST['message']))
      ) 
  {
    $_SESSION['errors'][] = ['title' => 'Поля формы пустые. Заполните данные для отправки.'];
  } else {

      // Проверка на пустое поле имени
      if ( empty(trim($_POST['name'])) ) {
        $_SESSION['errors'][] = ['title' => 'Введите имя'];
      } else {

        // Проверка на пустое поле email
        if ( empty(trim($_POST['email'])) ) {
          $_SESSION['errors'][] = ['title' => 'Введите email'];
        } else {

          // Проверка на формат email
          if ( !filter_var(htmlentities(trim($_POST['email'])), FILTER_VALIDATE_EMAIL) )  {
          $_SESSION['errors'][] = ['title' => 'Неверный формат email'];
          } else if ( trim($_POST['email']) ) {
            $result = true;
            $blockedUsers  = R::findOne( 'blockedusers', ' email = ? ', [ $_POST['email'] ] );
            $result = $blockedUsers !== NULL ? true : false;
            
            if ($result) {
              $_SESSION['errors'][] = ['title' => 'Ошибка, невозможно отправить сообщение.'];
            }
          } else {

            // Проверка на пустое сообщение
            if ( empty(trim($_POST['message']))) {
              $_SESSION['errors'][] = ['title' => 'Вы не можете отправить пустое сообщение'];
            } else {
              if ( mb_strlen(trim($_POST['message'])) < 10) {
                $_SESSION['errors'][] = ['title' => 'Текст сообщения слишком короткий'];
              }
            }

          }
        }
      }
} 

if (empty($_SESSION['errors'])) {
  $message = R::dispense('messages');
  $message->email = filter_var(htmlentities(trim($_POST['email'])), FILTER_VALIDATE_EMAIL);
  $message->name = htmlentities(trim($_POST['name']));
  $message->message = htmlentities(trim($_POST['message']));
  $message->phone = htmlentities(trim($_POST['phone']));
  $message->timestamp = time();
  $message->status = 'new';

  // if( isset($_FILES['file']['name']) && $_FILES['file']['tmp_name'] !== '') {
  //   $file = saveUploadedFile('file', 12, 'contact-form');
  //   $message->fileNameSrc = $file[0];
  //   $message->fileNameOriginal = $file[1];
  // }

  if( isLoggedIn() ) {
    $message->user_id = $_SESSION['logged_user']['id'];
  }

  R::store($message);
  $_SESSION['success'][] = ['title' => 'Сообщение отправлено успешно'];
  $_POST = array();
}
}

$pageTitle = "Контакты";
// Шаблон страницы
include ROOT . 'templates/_page-parts/_head.tpl';
include ROOT . 'templates/_parts/_header.tpl';

include ROOT . 'templates/contacts/contacts.tpl';

include ROOT . 'templates/_parts/_footer.tpl';
include ROOT . 'templates/_page-parts/_foot.tpl';