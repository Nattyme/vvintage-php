<?php

declare(strict_types=1);

namespace Vvintage\Models\User;

use Vvintage\Repositories\UserRepository;
use Vvintage\Models\Cart\Cart;

final class User
{
    private int $id;
    private string $password;
    private string $email;
    private string $name;
    private string $role;
    private array $fav_list;

    public Cart $cart;

    public function __construct($bean)
    {

        $this->id = (int) $bean['id'];
        $this->email = $bean['email'];
        $this->password = $bean['password'];
        $this->name = $bean['name'];
        $this->role = $bean['role'] ?? 'user';
        $cartData = isset($bean['cart']) ? json_decode($bean->cart ?? '[]', true) : [];
        $this->cart = new Cart(new UserRepository(), $cartData);
        $this->fav_list = [];
        // $this->fav_list = json_decode($bean->fav_list ?? '[]', true);
    }

    public function export($user): array
    {
        return [
          'id' => $this->id,
          'name' => $this->name,
          'email' => $this->email,
          'role' => $this->role,
          'password' => $this->password,
          'cart' => $this->cart,
          'fav_list' => $this->fav_list
        ];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getEmail(): string
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

    /**
     * @return Cart
     */
    public function getCartModel(): Cart
    {
        return $this->cart;
    }

    public function getFavList()
    {
        return $this->fav_list;
    }
}
