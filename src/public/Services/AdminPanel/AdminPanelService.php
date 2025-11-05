<?php
declare(strict_types=1);

namespace Vvintage\Public\Services\AdminPanel;

use Vvintage\Public\Services\Messages\MessageService;
use Vvintage\Public\Services\Order\OrderService;

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
