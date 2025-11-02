<?php 
declare(strict_types=1);

namespace Vvintage\Services\Profile;

use Vvintage\Services\User\UserService;
use Vvintage\Services\Order\OrderService;
use Vvintage\Services\Validation\ProfileValidator;
use Vvintage\Models\User\User;


class ProfileService 
{
  private UserService $userService;
  private OrderService $orderService;
  private ProfileValidator $validator;

  public function __construct()
  {
    $this->userService = new UserService();
    $this->orderService = new OrderService();
    $this->validator = new ProfileValidator();
  }

  public function getFullProfileData (int $id): array 
  {
    $userModel = $this->userService->getUserByID($id);  
    $orders = $this->orderService->getProfileOrdersList($id);

    return ['userModel' => $userModel, 'orders' => $orders ?? null];
  }

 
  public  function updateUserAndGoToProfile (array $data, array $files, User $userModel) {
      $file = $files['avatar'] ?? [];
      $avatars = [];
      $avatarsToDelete = [];

      $this->userService->beginTransaction();

      try {
          // Если ошибок нет - сохраняем
          if ( !empty($file['name']) && $file['tmp_name'] !== '') {
            $this->validator->validateEditAvatar($file); // если невалидно — выбросится исключение

            $result = $this->userService->handleAvatar($userModel, $file);
            if (empty($result['avatar']) || empty($result['avatar_small'])) throw new \Exception('Ошибка при обработке изображения.');
            

            // Новые изображения
            $avatars = [
                'avatar' => $result['avatar'],
                'avatar_small' => $result['avatar_small']
            ];

            // Старые изображения
            $avatarsToDelete = [
                'old_avatar' => $result['old_avatar'],
                'old_avatar_small' => $result['old_avatar_small']
            ];

            // Добавляем данные аватара в к массиву данных
            $data = array_merge($data, $avatars);
          }

          $this->validator->validateEdit($data); // если невалидно — выбросится исключение

          $dto = $this->userService->getUserUpdateDto($data); // dto пользователя для БД

          // Обновляем пользователя dв БД
          $this->userService->updateUser($dto, $userModel->getId());

          // Подтверждаем транзакцию 
          $this->userService->commit();

          // Удаляем старые аватары
          if($avatarsToDelete) {
            $this->userService->deleteAvatar($avatarsToDelete);
          }
      }
      catch (\Throwable $error)
      {
        $this->userService->rollback();
        throw $error; // отдаем ошибку в контроллер
      }

  
  }

}
