<?php
declare(strict_types=1);

namespace Vvintage\Models\User;

use Vvintage\Repositories\UserRepository;
use Vvintage\Models\User\UserInterface;
use RedBeanPHP\OODBBean; // для обозначения типа даннных
use Vvintage\Models\Cart\Cart;
use Vvintage\Models\Favorites\Favorites;

final class User implements UserInterface
{
    private int $id;
    private string $password;
    private string $email;
    private string $name;
    private string $role;
    private array $fav_list;
    private array $cart;
    private string $country;
    private string $city;
    private string $phone;
    private string $avatar;
    private string $avatarSmall;
    private int $address;

    public function __construct(OODBBean $bean)
    {
      $this->id = (int) $bean->id;
      $this->email = $bean->email;
      $this->password = $bean->password;
      $this->name = $bean->name ?? 'Пользователь';
      $this->role = $bean->role ?? 'user';

      // $cartData = isset($bean->cart) ? json_decode($bean->cart, true) : [];
      $this->cart = is_string($bean->cart) ? json_decode($bean->cart ?? '[]', true) : [];
      $this->fav_list = is_string($bean->fav_list) ? json_decode($bean->fav_list ?? '[]', true) : [];
      $this->address = (int) $bean->address;
        
      $this->country= $bean->country ?? '';
      $this->city= $bean->city ?? '';
      $this->phone= $bean->phone ?? '';
      $this->avatar= $bean->avatar ?? '';
      $this->avatarSmall = $bean->avatar_small ?? '';
    }

    public function getRepository(): UserRepository {
      return new UserRepository();
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
          'fav' => $this->fav_list,
          'country' => $this->country,
          'city' => $this->city,
          'phone' => $this->phone,
          'address' => $this->address,
          'avatar' => $this->avatar
        ];
    }

    public function load (): array 
    {
      $userRepository = $this->getRepository();
      $this->cart = $userRepository->getUserCart($this); // если у тебя есть такой метод

      return $this->cart;
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

    public function getSurname(): string
    {
      return $this->name;
    }

    public function getCountry(): string
    {
      return $this->country;
    }

    public function getCity(): string
    {
      return $this->city;
    }

    public function getPhone():string
    {
      return $this->phone;
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getAvatar()
    {
      return $this->avatar;
    }

    /**
     * @return Cart
     */
    public function getCart(): array
    {
        return $this->cart;
    }

    public function set($itemKey, array $items): void
    {
      $this->$itemKey = $items;
    }

    // public function setFav(array $fav): void 
    // {
    //   $this->fav = $fav;
    // }

    public function getCartModel(): Cart
    {
      return new Cart($this->cart);
    }

    public function getFavList(): array
    {
        return $this->fav_list;
    }

    public function getFavModel(): Favorites
    {      
      return new Favorites ($this->fav_list);
    }

    public function getAddress() {
      return $this->address;
    }

}
