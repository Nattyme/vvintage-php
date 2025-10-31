<?php
declare(strict_types=1);

namespace Vvintage\Models\User;

use RedBeanPHP\OODBBean; // для обозначения типа даннных

/** Контракт */
use Vvintage\Contracts\User\UserInterface;

/** Репозитории */
use Vvintage\Repositories\User\UserRepository;
use Vvintage\Repositories\Address\AddressRepository;

/** Модели */
use Vvintage\Models\Address\Address;
use Vvintage\Models\Cart\Cart;
use Vvintage\Models\Favorites\Favorites;

use Vvintage\DTO\User\UserOutputDTO;
// use Vvintage\DTO\Address\AddressDTO;

final class User implements UserInterface
{
    private int $id;
    private string $password;
    private string $email;
    private string $name;
    private string $surname;
    private string $role;

    private array $fav_list;
    private array $cart;

    private string $country;
    private string $city;
    private string $phone;
    private string $avatar;
    private string $avatar_small;
    
    private function __construct() {}

    
    public static function fromDTO(UserOutputDTO $dto): self
    {
        $user = new self();
        $user->id = (int) $dto->id;
        $user->password = (string) $dto->password;
        $user->email = (string) $dto->email;
        $user->name = (string) $dto->name;
        $user->surname = (string) $dto->surname;
        $user->role = (string) $dto->role;
      
        $user->fav_list = $dto->fav_list;
        $user->cart = $dto->cart;

        $user->country = (string) $dto->country;
        $user->city = (string) $dto->city;
        $user->phone = (string) $dto->phone;
        $user->avatar = (string) $dto->avatar;
        $user->avatar_small = (string) $dto->avatar_small;
      
        return $user;
    }

    public static function fromArray(array $data): self
    {
        $user = new self();
        $user->id = (int) ($data['id'] ?? 0);
        $user->password = (string) ($data['password'] ?? '');
        $user->email = (string) ($data['email'] ?? '');
        $user->name = $data['name'] ?? '';
        $user->surname = $data['surname'] ?? '';
        $user->role = (string) ($data['role'] ?? 'Пользователь');
        $user->fav_list = (string) ($data['fav_list'] ?? []);
        $user->cart = (string) ($data['cart'] ?? []);

        $user->country = (string) ($data['country'] ?? '');
        $user->city = (string) ($data['city'] ?? '');
        $user->phone = (string) ($data['phone'] ?? '');
         
        $user->avatar = (string) ($data['avatar'] ?? '');
        $user->avatar_small = (string) $dto->avatar_small;
           
        return $user;
    }
  

    public function getRepository(): UserRepository {
      return new UserRepository();
    }

    public function export(): array
    {
        return [
          'id' => $this->id,
          'name' => $this->name,
          'surname' => $this->surname,
          'email' => $this->email,
          'role' => $this->role,
          // 'password' => $this->password,
          'cart' => $this->cart,
          'fav' => $this->fav_list,
          'country' => $this->country,
          'city' => $this->city,
          'phone' => $this->phone,
          // 'address' => $this->getAddress(),
          'avatar' => $this->avatar,
          'avatar_small' => $this->avatar_small
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
      return $this->surname;
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

    public function getAvatar(): string
    {
      return $this->avatar;
    }

    public function getAvatarSmall(): string
    {
      return $this->avatar_small;
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
}
