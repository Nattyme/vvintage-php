<?php
declare(strict_types=1);

namespace Vvintage\Contracts\User;

use Vvintage\Models\User\User;

interface UserRepositoryInterface
 { 
    public function getUserById(int $id): ?User;
    public function getUserByEmail(string $email): ?User;
    public function getRecoveryCode (User $userModel): ?string;
    public function getAllUsers(): array;

    public function findBlockedUserByEmail (string $email): bool;
    public function createUser(array $postData): ?User;
    // public function editUser(array $postData, int $userId): ?User;
    public function saveUserItemsList(string $itemKey, User $userModel, array $items): void;
    public function removeUser(User $userModel): void;

    public function setRecoveryCode (User $userModel, string $recoveryCode): void;
    public function updateUserPassword (User $userModel, string $password): void;
    // public function updateUserAddressId(int $userId, int $addressId): void;
    // public function ensureUserHasAddress(User $userModel): ?int;
    public function getItemsList(int $userId, string $itemsKey): array;   
    public function getAllUsersCount(?string $sql = null, array $params = []): int;
  }
