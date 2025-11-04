<?php
declare(strict_types=1);

namespace Vvintage\public\Services\AdminPanel;

use Vvintage\public\Services\Messages\MessageService;
use Vvintage\public\Services\Order\OrderService;

class AdminPanelService
{
    private MessageService $messageService;
    private OrderService $orderService;

    public function __construct()
    {
        $this->messageService = new MessageService();
        $this->orderService = new OrderService();
    }

    public function getCounters(): array
    {
        return [
            'newMessages' => $this->messageService->getAllMessagesCount('status = ?', ['new']),
            'newOrders' => $this->orderService->getAllOrderaCount('status = ?', ['new'])
        ];
    }
}
