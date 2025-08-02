<?php
declare(strict_types=1);

namespace Vvintage\Contracts\User;

use Vvintage\Models\User\User;

interface UserRepositoryInterface
 { 
  
    public function hashPassword(string $password): string;

    /**
     * Метод ищет пользователя по id
     * @param int $id
     * @return User|null
     */
    public function getUserById(int $id): ?User;

    /**
     * Метод ищет пользователя по email
     * @param string $email
     * @return OODBBean
     */
    public function getUserByEmail(string $email): ?User;

    public function findBlockedUserByEmail (string $email): bool;

    /**
     * Метод возвращает всех пользователей
     * 
     * @return array
     */
    public function getAllUsers(): array;

    /**
     * Метод создает нового пользователя 
     * 
     * @return User|null
    */
    public function createUser(array $postData): ?User;


    /**
     * Метод редактирует пользователя 
     * @param User $userModel, array $newUserData
     * @return User|null
     */
    public function editUser(User $userModel, array $postData): ?User;

    public function setRecoveryCode (User $userModel, string $recoveryCode): void;

    public function getRecoveryCode (User $userModel): ?string;

    public function updateUserPassword (User $userModel, string $password): void;

    /**
     * Метод сохраняет id адреса в поле теблицы User
    */
    public function updateUserAddressId(int $userId, int $addressId): void;

    public function ensureUserHasAddress(User $userModel): ?int;

  
    /**
     * Метод обновляет корзину
     * @return void
     */
    public function saveUserItemsList(string $itemKey, User $userModel, array $items): void;

    /**
     * Метод удаления пользователя 
     * 
     * @return void
    */
    public function removeUser(User $userModel): void;


    /**
     * Метод возвращает корзину user из БД
     * @return array
    */
    public function getItemsList(int $userId, string $itemsKey): array;   
  }
