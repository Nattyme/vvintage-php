<?php
declare(strict_types=1);

namespace Vvintage\Services\AdminPanel;

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
            'newMessages' => $this->messageService->countUnread(),
            'newOrders' => $this->orderService->countNew(),
        ];
    }
}
