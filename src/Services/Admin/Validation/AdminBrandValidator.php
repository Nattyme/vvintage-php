<?php
declare(strict_types=1);

namespace Vvintage\Services\Admin\Validation;
use Vvintage\Services\Messages\FlashMessage;

final class AdminBrandValidator
{
  private FlashMessage $notes;

  public function __construct()
  {
    $this->notes = new FlashMessage();
  }

  public function new(array $data): bool
  {
    $valid = true;

    $csrfToken = $data['csrf'] ?? '';
    if (!check_csrf($csrfToken)) {
      $this->notes->pushError('Неверный токен безопасности');
      $valid = false;
    } 

    // Проверка на заполненность названия
    foreach ($_POST['title'] as $key => $value) {
        if (trim($value) === '') {
            $flagPath = HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#flag-' . $key;
            $this->notes->pushError('Пустое поле', 'Заполните название бренда', $flagPath);
        }
    }



    // Проверка на заполненность описания
    // if( trim($_POST['description']) == '' ) {
    //   $_SESSION['errors'][] = ['title' => 'Заполните описание поста'];
    // } 

    // $email = trim( strtolower($data['email']) ?? '');
    // if ($email === '') {
    //   $this->notes->renderError('Введите email');
    //   $valid = false;
    // } 


    return $valid;
  }
}

