<?php 
declare(strict_types=1);

namespace Vvintage\Models\User;

final class User
{
  private int $id;
  private string $email;
  private string $name;
  private string $role;

  public function __construct (array $userData)
  {
    $this->id = (int) $userData['id'];
    $this->email =  $userData['email'];
    $this->name = $userData['name'];
    $this->role = $userData['role'] ?? 'user';
  }

  public function getId(): int {
    return $this->id;
  }

  public function getEmail():string
  {
    return $this->email;
  }

  public function getName(): string 
  {
    return $this->name;
  }

  public function isAdmin(): bool
  {
    return $this->role === 'admin';
  }

  public function getRole(): string
  {
    return $this->role;
  }
}