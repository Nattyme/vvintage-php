<?php
declare(strict_types=1);

namespace Vvintage\admin\Services;

/** Репозитории */
use Vvintage\Repositories\Order\OrderRepository;
use Vvintage\Repositories\Post\PostRepository;
use Vvintage\Repositories\Product\ProductRepository;
use Vvintage\Repositories\User\UserRepository;

class AdminStatsService {
  private PostRepository $postRepository;
  private ProductRepository $productRepository;
  private OrderRepository $orderRepository;
  private UserRepository $userRepository;

  public function __construct()
  {
    $this->productRepository = new ProductRepository();
    $this->postRepository = new PostRepository();
    $this->orderRepository = new OrderRepository();
    $this->userRepository = new UserRepository();
  }

  public function getSummary(): array {

      return [
          'newOrders' => $this->orderRepository->getAllOrdersCount('status = ?', ['new']),
          // 'messages' => MessageRepository::countUnread(),
          'posts' => $this->postRepository->getAllPostsCount(),
          'products' => $this->productRepository->getAllProductsCount(),
          'users' => $this->userRepository->getAllUsersCount()
      ];
  }
}
