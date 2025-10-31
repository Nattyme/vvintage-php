<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Admin\Message;

use Vvintage\Routing\RouteData;
use Vvintage\Controllers\Admin\BaseAdminController;
use Vvintage\Repositories\Message\MessageRepository;

/** Сервисы */
use Vvintage\Services\Admin\Messages\AdminMessageService;



class AdminMessageController extends BaseAdminController 
{
  private AdminMessageService $service;


  public function __construct()
  {
    parent::__construct();
    $this->service = new AdminMessageService();
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
    $messages = $this->service->getAllMessages($pagination);
    $total = $this->service->getAllMessagesCount();

        
    $this->renderLayout('messages/all',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
      'messages' => $messages,
      'pagination' => $pagination,
      'flash' => $this->flash
    ]);

  }

  private function renderSingle(RouteData $routeData): void
  {
     // Название страницы
    $pageTitle = 'Сообщениe';

    $messageId = (int) $routeData->uriGet;
    $message = $this->service->getMessage( $messageId);
  
        
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
    $id = (int) $routeData->uriGet;
    $message = $this->service->getMessage( $id);


    // Если отправлена форма
    if (isset($_POST['submit'])) {
      $csrfToken = $_POST['csrf'] ?? '';

      if (!$csrfToken) {
        $this->flash->pushError('Неверный токен безопасности');
        $this->redirect('admin/messages');
      }

      // Удаляем сообщение
      $this->service->deleteMessage($id);

      $this->flash->pushSuccess('Сообщение успешно удалено.');
      $this->redirect('admin/messages');
    }

    // Если нет ошибок

      // Удаление файла
      // if ( !empty($message['file_name_src']) ) {

      //   // Удадить файлы с сервера
      //   $fileFolderLocation = ROOT . 'usercontent/contact-form/';
      //   unlink($fileFolderLocation . $message->file_name_src);
      // }

      // R::trash($message);
      // $_SESSION['success'][] = ['title' => 'Сообщение было успешно удалено.'];
     
      // header('Location: ' . HOST . 'admin/messages');
      // exit();

        
    $this->renderLayout('messages/delete',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
      'message' => $message,
      'flash' => $this->flash
    ]);

  }

}