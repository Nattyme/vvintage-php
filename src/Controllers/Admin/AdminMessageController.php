<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Admin;

use Vvintage\Routing\RouteData;

/** Контроллеры */
use Vvintage\Controllers\Admin\BaseAdminController;

/** Репозитории */
use Vvintage\Repositories\Message\MessageRepository;

/** Сервисы */
use Vvintage\Services\Messages\FlashMessage;
// use Vvintage\Services\Admin\AdminStatsService;

class AdminMessageController extends BaseAdminController 
{
  private MessageRepository $messageRepository;
  private FlashMessage $notes;

  public function __construct(MessageRepository $messageRepository, FlashMessage $notes)
  {
    parent::__construct();
    $this->messageRepository = $messageRepository;
    $this->notes = $notes;
  }

  public function all(RouteData $routeData)
  {
    $this->isAdmin();
    $this->renderAll($routeData);
  }

  public function edit(RouteData $routeData)
  {
    $this->isAdmin();
    $this->renderEdit($routeData);
  }

  public function new(RouteData $routeData)
  {
    $this->isAdmin();
    $this->renderNew($routeData);
  }

  public function delete (RouteData $routeData)
  {
    $this->isAdmin();
    $this->renderDelete($routeData);
  }

  private function renderAll(RouteData $routeData): void
  {
    // Название страницы
    $pageTitle = 'Сообщения';

    $messagePerPage = 9;

    // Устанавливаем пагинацию
    $pagination = pagination($messagePerPage, 'messages');
    $messages = $this->messageRepository->getAllMessages($pagination);
    $total = $this->messageRepository->getAllMessagesCount();
        
    $this->renderLayout('messages/all',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
      'messages' => $messages,
      'pagination' => $pagination
    ]);

  }

  // private function renderNew(RouteData $routeData): void
  // {
  //   // Название страницы
  //   $pageTitle = 'Бренды - новая запись';

  //   // Устанавливаем пагинацию
  //   $pagination = pagination($brandsPerPage, 'brands');
  //   $brands = $this->brandRepository->getAllBrands($pagination);
  //   $total = $this->brandRepository->getAllBrandsCount();
        
  //   $this->renderLayout('brands/all',  [
  //     'pageTitle' => $pageTitle,
  //     'routeData' => $routeData,
  //     'brands' => $brands,
  //     'pagination' => $pagination
  //   ]);

  // }

  // private function renderEdit(RouteData $routeData): void
  // {
  //   // Название страницы
  //   $pageTitle = 'Бренды';

  //   $pageClass = 'admin-page';

  //   // Задаем название страницы и класс
  //   if( isset($_POST['submit'])) {
  //     // Проверка токена
  //     if (!check_csrf($_POST['csrf'] ?? '')) {
  //       $_SESSION['errors'][] = ['error', 'Неверный токен безопасности'];
  //     }

  //     // Проверка на заполненность названия
  //     if( trim($_POST['title']) == '' ) {
  //       $_SESSION['errors'][] = ['title' => 'Введите название бренда'];
  //     } 

  //     // Если нет ошибок
  //     if ( empty($_SESSION['errors'])) {
  //       $brand = $this->brandRepository->getBrandById((int) $routeData->uriGetParam);
  //       // $brand->title = $_POST['title'];

  //       // R::store($brand);

  //       $_SESSION['success'][] = ['title' => 'Бренд успешно обновлен.'];
  //     }
  //   }

  //   $currentLang = LanguageConfig::getCurrentLocale();

  //   // Запрос постов в БД с сортировкой id по убыванию
  //   $brand = $this->brandRepository->getBrandById( (int) $routeData->uriGetParam);


        
  //   $this->renderLayout('brands/edit',  [
  //     'pageTitle' => $pageTitle,
  //     'routeData' => $routeData,
  //     'brand' => $brand,
  //     'languages' => $this->languages,
  //     'currentLang' => $currentLang
  //   ]);

  // }

  // private function renderDelete(RouteData $routeData): void
  // {
  //   // Название страницы
  //   $pageTitle = 'Бренды';

  //   $brandsPerPage = 9;

  //   // Устанавливаем пагинацию
  //   $pagination = pagination($brandsPerPage, 'brands');
  //   $brands = $this->brandRepository->getAllBrands($pagination);
  //   $total = $this->brandRepository->getAllBrandsCount();
        
  //   $this->renderLayout('brands/all',  [
  //     'pageTitle' => $pageTitle,
  //     'routeData' => $routeData,
  //     'brands' => $brands,
  //     'pagination' => $pagination
  //   ]);

  // }

}