<?php

declare(strict_types=1);

namespace Vvintage\Repositories\User;

use RedBeanPHP\R; // Подключаем readbean
use RedBeanPHP\OODBBean; // для обозначения типа даннных

/** Контракты */
use Vvintage\Contracts\User\UserRepositoryInterface;

/** Абстрактный репозиторий */
use Vvintage\Repositories\AbstractRepository;

use Vvintage\Models\User\User;
use Vvintage\Public\DTO\User\UserUpdateDTO;
use Vvintage\Public\DTO\User\UserCreateDTO;

final class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    private const TABLE_USERS = 'users';
    private const TABLE_BLOCKED_USERS = 'blockedusers';


    /**
     * Метод ищет пользователя по id
     * @param int $id
     * @return User|null
     */
    public function getUserById(int $id): ?User
    {
        $bean = $this->loadBean(self::TABLE_USERS, $id);

        if ($bean->id === 0) return null;


        return $this->mapBeanToUser($bean);
    }


    /**
     * Метод ищет пользователя по email
     * @param string $email
     * @return OODBBean
     */
    public function getUserByEmail(string $email): ?User
    {
      $bean = $this->findOneBy(self::TABLE_USERS, 'email = ?', [strtolower($email)]);

      if (!$bean) return null;

      return $this->mapBeanToUser($bean);;
    }

    private function mapBeanToUser(OODBBean $bean): User
    {
        return User::fromArray([
            'id' => (int) $bean->id,
            'password' => (string) $bean->password,
            'email' => (string) $bean->email,
            'name' => (string) $bean->name,
            'surname' => (string) $bean->surname,
            'role' => (string) $bean->role,

            'fav_list' => (string) $bean->fav_list,
            'cart' => (string) $bean->cart,

            'country' => (string) $bean->country,
            'city' => (string) $bean->city,
            'phone' => (string) $bean->phone,

            'avatar' => (string) $bean->avatar,
            'avatar_small' => (string) $bean->avatar_small,
        ]);
    }


    public function findBlockedUserByEmail (string $email): bool 
    {
      $bean = $this->findOneBy(self::TABLE_BLOCKED_USERS, 'email = ?', [strtolower($email)]);
      return $bean ? true : false;
    }

    /**
     * Метод возвращает всех пользователей
     * 
     * @return array
     */
    public function getAllUsers(): array
    {
        $beans = $this->findAll(table: self::TABLE_USERS);

        if (empty($beans)) return [];


        return array_map([$this, 'mapBeanToUser'], $beans);
    }

    /**
     * Метод создает нового пользователя 
     * 
     * @return User|null
    */
    public function createUser(array $dto): ?User
    {
      return $this->saveNewUser($dto);
    }

  

  public function saveNewUser(UserCreateDTO $dto): ?User
  {
      $bean = $this->createBean(self::TABLE_USERS);
      $bean->password = $this->hashPassword($dto->password);
      $bean->email = strtolower($dto->email);
      $bean->name = $dto->name ?? '';
      $bean->role = $dto->role && trim($dto->role) !== '' ? $dto->role : 'customer';

      // JSON поля
      $bean->fav_list = json_encode($dto->fav_list ?? []);
      $bean->cart = json_encode($dto->cart ?? []);
      $bean->country = $dto->country ?? '';
      $bean->city = $dto->city ?? '';
      $bean->phone = $dto->phone ?? '';
      $bean->avatar = $dto->avatar ?? '';
      $bean->avatar_small = $dto->avatar_small ?? '';

      $this->saveBean($bean);

      return $this->mapBeanToUser($bean);
  }

  public function updateUser(UserUpdateDTO $dto, int $id): ?User
  {
      $bean = $this->loadBean(self::TABLE_USERS, $id);
      if (!$bean || $bean->id === 0) return null;

      $bean->name = $dto->name ?? $bean->name;
      $bean->surname = $dto->surname ?? $bean->surname;
      $bean->country = $dto->country ?? $bean->country;
      $bean->city = $dto->city ?? $bean->city;
      $bean->phone = $dto->phone ?? $bean->phone;

      // Аватар обновляем только если пришёл новый
      if (!empty($dto->avatar)) {
          $bean->avatar = $dto->avatar;
          $bean->avatarSmall = $dto->avatar_small;
      }

      $this->saveBean($bean);

      return $this->mapBeanToUser($bean);
  }

    public function setRecoveryCode (User $userModel, string $recoveryCode): ?int
    {
      $id = $userModel->getId();
      $bean = $this->loadBean(self::TABLE_USERS, $id);

      if ($bean) {
        $bean->recovery_code = $recoveryCode;

        return $this->saveBean($bean) ?? 0;
      }

    }

    public function getRecoveryCode (User $userModel): ?string
    {
      $id = $userModel->getId();
      $bean = $this->loadBean(self::TABLE_USERS, $id);

      if ($bean->id !== 0) return $bean->recovery_code;

      return null;
    }

    public function updateUserPassword (User $userModel, string $password): void
    {
      $id = $userModel->getId();
      $bean = $this->loadBean(self::TABLE_USERS, $id);

      if ($bean->id !== 0) {
        $bean->password = $this->hashPassword($password);
        $this->saveBean($bean);
      }
    }

    
    private function hashPassword(string $password): string
    {
      return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Метод обновляет корзину
     * @return void
     */
    public function saveUserItemsList(string $itemKey, User $userModel, array $items): void
    {
        // Находим bean пользователя по id из модели
        $userId = $userModel->getId();
        $userBean = $this->loadBean(self::TABLE_USERS, $userId);

        // Обновляем корзину
        $userBean->$itemKey = json_encode($items);
        $this->saveBean($userBean);
    }


    /**
     * Метод удаления пользователя 
     * 
     * @return void
    */
    public function removeUser(User $userModel): void
    {
      $id = $userModel->getId();
      $bean = $this->loadBean(self::TABLE_USERS, $id);

      if ($bean->id !== 0) $this->deleteBean( $bean ); 
    }


    /**
     * Метод возвращает корзину user из БД
     * @return array
    */
    public function getItemsList(int $userId, string $itemsKey): array
    {
        // Находим bean пользователя по id из модели
        $bean = $this->loadBean(self::TABLE_USERS, $userId);

        // Получаем корзину из БД и переводим в массив
        $userItems = !empty($bean->$itemsKey) ? json_decode($bean->$itemsKey, true) : [];
        return $userItems;
    }

    public function getAllUsersCount(?string $sql = null, array $params = []): int
    {
      return $this->countAll('users', $sql, $params);
    }
}
