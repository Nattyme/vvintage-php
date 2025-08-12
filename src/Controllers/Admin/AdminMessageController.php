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
use Vvintage\Services\Admin\AdminMessageService;



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
      'messages' => $messages,
      'pagination' => $pagination
    ]);
  }



  private function renderDelete(RouteData $routeData): void
  {
    // Название страницы
    $pageTitle = 'Бренды';

    $brandsPerPage = 9;

    // Устанавливаем пагинацию
    $pagination = pagination($brandsPerPage, 'brands');
    $brands = $this->brandRepository->getAllBrands($pagination);
    $total = $this->brandRepository->getAllBrandsCount();
        
    $this->renderLayout('messages/all',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
      'brands' => $brands,
      'pagination' => $pagination
    ]);

  }

}