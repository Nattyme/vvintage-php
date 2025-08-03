<?php
declare(strict_types=1);

namespace Vvintage\Controllers\AdminPanel;

use Vvintage\Models\Order\Order;
use Vvintage\Repositories\Order\OrderRepository;
// use Vvintage\Models\Message;
// use Vvintage\Models\Comment;

final class AdminPanelController 
{
  // private $messagesCount;
  private $newOrders;

  public function index()
  {
    $this->setAdminPanelData();
    return $this->getPanelData();
  }

  private function setAdminPanelData(): void
  {
    $orderRepository = new OrderRepository();
    $orderRepository->getAllOrdersCount('status = ?', ['new']);
  }

  public function getPanelData(): array
  {

      return [
          'newOrders' => $this->newOrders
      //  'newMessages' => Message::countUnread(),
      //     'newComments' => Comment::countPending()   
      ];
  }
}

