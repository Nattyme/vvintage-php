<?php
declare(strict_types=1);

namespace Vvintage\Services\User;

/** Модели */
use Vvintage\Models\User\User;
use Vvintage\Models\Address\Address;
use Vvintage\Models\Order\Order;

/** Сервисы */
use Vvintage\Services\Base\BaseService;
use Vvintage\Services\Address\AddressService;
use Vvintage\Services\Product\ProductService;
use Vvintage\Repositories\AddressRepository;

/** Репозитории */
use Vvintage\Repositories\Order\OrderRepository;
use Vvintage\Repositories\User\UserRepository;

class UserService extends BaseService
{
  protected UserRepository $userRepository;
  protected AddressService $addressService;
  protected OrderRepository $orderRepository;
  protected ProductService $productService;

  public function __construct () {
    parent::__construct();
    $this->userRepository = new UserRepository ();
    $this->addressService = new AddressService();
    $this->orderRepository = new OrderRepository();
    $this->productService = new ProductService( $this->currentLang);
  }
  
// createNewUser
  public function createUser (array $postData): ?User
  {
  
    /**
     * @var User|null
    */
    $userModel = $this->userRepository->createUser($postData);
    $userId = $userModel->getId();

    // if ( is_int($userId) ) {
    //   // Создаем адрес пользователя в таблицу адресов доставки и сохраняем Id адреса 
    //   $addressModel = $this->addressService->createAddress( $userId, $postData);
    //   $addressId = $addressModel->getId();

    //   // Обновляем пользователя, добавляя id адреса
    //   $this->userRepository->updateUserAddressId( $userId, $addressId );
    // }

    return $userModel;
  }

  public function getOrdersByUserId(int $id): array
  {
    return  $this->orderRepository->getOrdersByUserId($id);
  }

  public function getOrderById(int $id)
  {
     return $this->orderRepository->getOrderById($id);
  }

  public function getProductsByIds(array $ids)
  {
    return $this->productRepository->getProductsByIds($ids);
  }
}