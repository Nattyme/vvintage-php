<?php
declare(strict_types=1);

namespace Vvintage\Services\AdminPanel;

use Vvintage\Services\Messages\MessageService;
use Vvintage\Services\Order\OrderService;

class AdminPanelService
{

    public function __construct(
      private MessageService $messageService,
      private OrderService $orderService
    ){}

    public function getCounters(): array
    {
        return [
            'newMessages' => $this->messageService->getAllMessagesCount('status = ?', ['new']),
            'newOrders' => $this->orderService->getAllOrderaCount('status = ?', ['new']),
        ];
    }
}
