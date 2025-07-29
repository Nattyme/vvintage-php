<?php
declare(strict_types=1);

namespace Vvintage\Services\Admin;

/** Репозитории */
use Vvintage\Repositories\OrderRepository;
// use Vvintage\Repositories\MessageRepository;
use Vvintage\Repositories\PostRepository;
use Vvintage\Repositories\ProductRepository;

class AdminStatsService {
  private PostRepository $postRepository;
  private ProductRepository $productRepository;
  private OrderRepository $orderRepository;

  public function __construct()
  {
    $this->productRepository = new ProductRepository();
    $this->postRepository = new PostRepository();
    $this->orderRepository = new OrderRepository();
  }

  public function getSummary(): array {
      return [
          'newOrders' => $this->orderRepository->countNew(),
          // 'messages' => MessageRepository::countUnread(),
          'posts' => $this->postRepository->countAll(),
          'products' => $this->productRepository->countAll(),
      ];
  }
}
