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
use Vvintage\DTO\User\UserUpdateDTO;

require_once ROOT . './libs/functions.php';

class UserService extends BaseService
{
  protected UserRepository $userRepository;
  protected AddressService $addressService;
  protected OrderRepository $orderRepository;
  protected ProductService $productService;

  private const FOLDER_NAME = 'avatars';
  private const AVATAR_FULL_SIZE = [160, 160];
  private const AVATAR_SMALL_SIZE = [48, 48];
  private const EXTENSIONS = [
                                  IMAGETYPE_GIF  => 'gif',
                                  IMAGETYPE_JPEG => 'jpg',
                                  IMAGETYPE_PNG  => 'png',
                                  IMAGETYPE_BMP  => 'bmp',
                                  IMAGETYPE_WEBP => 'webp',
                              ];

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

  public function handleFormData(User $userModel, array $data) 
  {
     return $this->userRepository->editUser($data, $userModel->getId());
  }

  public function handleAvatar(User $userModel, array $files): array
  {
      $fileTmpLoc = $files['tmp_name'] ?? null;
      $info = getimagesize($fileTmpLoc); // Получаем информацию о файле

      $mime = $info['mime'] ?? '';
      $type = $info[2] ?? null; // GD тип

      $fileExt = $extensions[$type] ?? 'jpg'; // по умолчанию jpg

      // Прописываем путь для хранения изображения
      $imgFolderLocation = ROOT . 'usercontent/' . self::FOLDER_NAME . '/';

      $db_file_name = rand(100000000000, 999999999999) . "." . $fileExt;


      $filePathFullSize = $imgFolderLocation . $db_file_name;
      $filePathSmallSize = $imgFolderLocation . self::AVATAR_SMALL_SIZE[0] . '-' . $db_file_name;


      // Обработать фотографию
      // 1. Обрезать до мах размера
      $resultFullSize = resize_and_crop($fileTmpLoc, $filePathFullSize, self::AVATAR_FULL_SIZE[0], self::AVATAR_FULL_SIZE[1]);
      // 2. Обрезать до мин размера
      $resultSmallSize = resize_and_crop($fileTmpLoc, $filePathSmallSize, self::AVATAR_SMALL_SIZE[0], self::AVATAR_SMALL_SIZE[1]);

      if ($resultFullSize != true || $resultSmallSize != true) {
        $this->flash->pushError('Ошибка сохранения файла');
        return false;
      }

      return ['avatar' => $db_file_name, 'avatar_small' => self::AVATAR_SMALL_SIZE[0] . '-' . $db_file_name,];
      // $avatarFileName = saveUploadedImg('avatar', [160, 160], 12, 'avatars', [160, 160], [48, 48]);
        
      // Если новое изображение успешно загружено - удаляем старое
      // if ($avatarFileName) {
      //   $avatarFolderLocation = ROOT . 'usercontent/avatars/';
      //   // Если есть старое изображение - удаляем 
      //   if (file_exists($avatarFolderLocation . $user->avatar) && !empty($user->avatar)) {
      //     unlink($avatarFolderLocation . $user->avatar);
      //   }

      //   if (file_exists($avatarFolderLocation . $user->avatarSmall) && !empty($user->avatarSmall)) {
      //     unlink($avatarFolderLocation . $user->avatarSmall);
      //   }

      //   // Записываем имя файлов в БД
      //   $user->avatar = $avatarFileName[0];
      //   $user->avatarSmall = $avatarFileName[1];
      // }
  }

  public function getUserUpdateDto(array $data): UserUpdateDTO 
  {
      $dto = new UserUpdateDTO([
                'name' => (string) $data['name'],
                'surname' => (string) $data['surname'],

                'fav_list' => json_encode($dto->fav_list ?? []),
                'cart' => json_encode($dto->cart ?? []),

                'country' => (string) $data['country'],
                'city' => (string) $data['city'],
                'phone' => (string) $data['phone'],

                'avatar' => isset($data['avatar']) ? (string)$data['avatar'] : null,
                'avatar_small' => isset($data['avatar_small']) ? (string)$data['avatar_small'] : null,
            ]);
    return $dto;
  }

  public function updateUser (UserUpdateDTO $dto, int $id) 
  {
    return $this->userRepository->updateUser($dto, $id);
  }
}