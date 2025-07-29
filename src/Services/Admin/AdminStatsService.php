<?php
declare(strict_types=1);

namespace Vvintage\Services\Admin\AdminStatsService;

class AdminStatsService {
    public function getSummary(): array {
        return [
            'newOrders' => OrderRepository::countNew(),
            'messages' => MessageRepository::countUnread(),
            'posts' => PostRepository::countAll(),
        ];
    }
}
