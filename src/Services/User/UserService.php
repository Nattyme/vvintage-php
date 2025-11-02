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
  private const FOLDER_LOCATION = ROOT . 'usercontent/';
  private const FILE_LOCATION = self::FOLDER_LOCATION . self::FOLDER_NAME . '/';
   
  private const AVATAR_FULL_SIZE = [160, 160];
  private const AVATAR_SMALL_SIZE = [48, 48];


  public function __construct () {
    parent::__construct();
    $this->userRepository = new UserRepository ();
    $this->addressService = new AddressService();
    $this->orderRepository = new OrderRepository();
    $this->productService = new ProductService();
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
    return $this->productService->getProductsByIds($ids);
  }

  public function findBlockedUserByEmail(string $email) 
  {
    return  $this->userRepository->findBlockedUserByEmail($email);
  }

  // TODO:проверить где используется и удалить метод ниже. Использовать updateUser
  public function handleFormData(User $userModel, array $data) 
  {
     return $this->userRepository->editUser($data, $userModel->getId());
  }

 
  public function handleAvatar(User $userModel, array $file): array
  {
      // Получаем расширение файла
      $fileExt = pathinfo($file['name'], PATHINFO_EXTENSION) ?? 'jpg'; // по умолчанию jpg

      // Получаем информацию о файле
      $fileTmpLoc = $file['tmp_name'] ?? null;
  
      // Формируем имя файла
      $db_file_name = rand(100000000000, 999999999999) . "." . $fileExt;

      // Формируем пути для файла
      $filePathFullSize = self::FILE_LOCATION . $db_file_name;
      $filePathSmallSize = self::FILE_LOCATION . self::AVATAR_SMALL_SIZE[0] . '-' . $db_file_name;


      // Обработать фотографию
      // 1. Обрезать до мах размера
      $resultFullSize = resize_and_crop($fileTmpLoc, $filePathFullSize, self::AVATAR_FULL_SIZE[0], self::AVATAR_FULL_SIZE[1]);
      // 2. Обрезать до мин размера
      $resultSmallSize = resize_and_crop($fileTmpLoc, $filePathSmallSize, self::AVATAR_SMALL_SIZE[0], self::AVATAR_SMALL_SIZE[1]);

      if ($resultFullSize != true || $resultSmallSize != true) throw new \Exception('Ошибка обработки размера изображения');

      // Возвращаем аватары в двух размерах 
      return [
          'avatar' => $db_file_name, 
          'avatar_small' => self::AVATAR_SMALL_SIZE[0] . '-' . $db_file_name,
          'old_avatar' => $userModel->getAvatar(),
          'old_avatar_small' => $userModel->getAvatarSmall()
      ];
  }

/**
 * Удаляет файлы изображений, переданные в массиве $data.
 * 
 * @param array $data Массив с именами файлов для удаления.
 */
  public function deleteAvatar(array $data): void 
  {
    foreach ($data as $key => $value) {
      if (file_exists(self::FILE_LOCATION . $data[$key] ) && !empty($data[$key])) {
        unlink(self::FILE_LOCATION . $data[$key]);
      }

    }
  }

  public function getUserUpdateDto(array $data): UserUpdateDTO 
  {
      $dto = new UserUpdateDTO([
                'name' => (string) $data['name'],
                'surname' => (string) $data['surname'],

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

  // *** Методы транзакции ***
  public function beginTransaction(): void
  {
    $this->userRepository->begin();
  }

  public function commit(): void
  {
    $this->userRepository->commit();
  }

  public function rollback(): void
  {
    $this->userRepository->rollback();
  }

}