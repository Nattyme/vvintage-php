<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Admin\Message;

use Vvintage\Routing\RouteData;
use Vvintage\Controllers\Admin\BaseAdminController;
use Vvintage\Repositories\Message\MessageRepository;

/** Сервисы */
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Admin\Messages\AdminMessageService;



class AdminMessageController extends BaseAdminController 
{
  private AdminMessageService $adminMessageService;
  // private MessageRepository $messageRepository;
  private FlashMessage $notes;

  public function __construct(FlashMessage $notes)
  {
    parent::__construct();
    $this->adminMessageService = new AdminMessageService();
    $this->notes = $notes;
  }

  public function all(RouteData $routeData)
  {
    $this->isAdmin();
    $this->renderAll($routeData);
  }


  public function single(RouteData $routeData)
  {
    $this->isAdmin();
    $this->renderSingle($routeData);
  }

  public function delete(RouteData $routeData)
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
    $messages = $this->adminMessageService->getAllMessages($pagination);
    // $messages = $this->messageRepository->getAllMessages($pagination);
    $total = $this->adminMessageService->getAllMessagesCount();
    // $total = $this->messageRepository->getAllMessagesCount();
        
    $this->renderLayout('messages/all',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
      'messages' => $messages,
      'pagination' => $pagination
    ]);

  }

  private function renderSingle(RouteData $routeData): void
  {
     // Название страницы
    $pageTitle = 'Сообщениe';

    $messageId = (int) $routeData->uriGetParam;
    $message = $this->adminMessageService->getMessage( $messageId);
  
        
    $this->renderLayout('messages/single',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
      'message' => $message
    ]);
  }



  private function renderDelete(RouteData $routeData): void
  {

    // Название страницы
    $pageTitle = 'Удаление сообщения';
    $messageId = (int) $routeData->uriGetParam;
    $message = $this->adminMessageService->getMessage( $messageId);


     if (!check_csrf($_POST['csrf'] ?? '')) {
      $_SESSION['errors'][] = ['error', 'Неверный токен безопасности'];
    }

    // Если нет ошибок
    if ( empty($_SESSION['errors'])) {

      // Удаление файла
      // if ( !empty($message['file_name_src']) ) {

      //   // Удадить файлы с сервера
      //   $fileFolderLocation = ROOT . 'usercontent/contact-form/';
      //   unlink($fileFolderLocation . $message->file_name_src);
      // }

      // R::trash($message);
      // $_SESSION['success'][] = ['title' => 'Сообщение было успешно удалено.'];
     
      header('Location: ' . HOST . 'admin/messages');
      exit();
    }

        
    $this->renderLayout('messages/delete',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
      'message' => $message
    ]);

  }

}