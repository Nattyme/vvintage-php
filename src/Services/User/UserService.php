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

require_once ROOT . './libs/functions.php';

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

  public function getUserByID(int $id): ?User
  {
    return $this->userRepository->getUserById($id);
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

  public function findBlockedUserByEmail(string $email) 
  {
    return  $this->userRepository->findBlockedUserByEmail($email);
  }

  public function handleFormData(User $userModel, array $data, array $files) 
  {
    //  $dto = $this->userRepository->getUserUpdateDto();



    //  $user->name = htmlentities(trim($_POST['name']));
    // $user->surname = htmlentities(trim($_POST['surname']));
    // $user->email = htmlentities(trim($_POST['email']));
    // $user->country = htmlentities(trim($_POST['country']));
    // $user->city = htmlentities(trim($_POST['city']));
          // Если передано изображение - уменьшаем, сохраняем, записываем в БД



 
  }

  public function handleAvatar(User $userModel, array $files): array
  {
      //Если передано изображение - уменьшаем, сохраняем файлы в папку, получаем название файлов изображений
      $avatarFileName = saveUploadedImg('avatar', [160, 160], 12, 'avatars', [160, 160], [48, 48]);
        
      // Если новое изображение успешно загружено - удаляем старое
      if ($avatarFileName) {
        $avatarFolderLocation = ROOT . 'usercontent/avatars/';
        // Если есть старое изображение - удаляем 
        if (file_exists($avatarFolderLocation . $user->avatar) && !empty($user->avatar)) {
          unlink($avatarFolderLocation . $user->avatar);
        }

        if (file_exists($avatarFolderLocation . $user->avatarSmall) && !empty($user->avatarSmall)) {
          unlink($avatarFolderLocation . $user->avatarSmall);
        }

        // Записываем имя файлов в БД
        $user->avatar = $avatarFileName[0];
        $user->avatarSmall = $avatarFileName[1];
      }
  }

}