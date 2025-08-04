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

use Vvintage\DTO\User\UserDTO;
// use Vvintage\DTO\Address\AddressDTO;

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
    private string $avatar_small;
    
    private int $addressId;
    private Address $address;

    private function __construct() {}

    
    public static function fromDTO(UserDTO $dto): self
    {
        $user = new self();
        $user->id = (int) $dto->id;
        $user->password = (string) $dto->password;
        $user->email = (string) $dto->email;
        $user->name = (string) $dto->name;
        $user->role = (string) $dto->role;
      
        $user->fav_list = $dto->fav_list;
        $user->cart = $dto->cart;

        $user->country = (string) $dto->country;
        $user->city = (string) $dto->city;
        $user->phone = (string) $dto->phone;
        $user->avatar = (string) $dto->avatar;
        $user->avatar_small = (string) $dto->avatar_small;

        if ($dto->address) {
            $user->addressId = $dto->address->id;
            $user->address = Address::fromDTO($dto->address);
        }

     
        // $user->addressId = (string) $dto->addressId;

        // $brand->translations = $dto->translations;
      
        return $user;
    }

    public static function fromArray(array $data): self
    {
        $user = new self();
        $user->id = (int) ($data['id'] ?? 0);
        $user->password = (string) ($data['password'] ?? '');
        $user->email = (string) ($data['email'] ?? '');
        $user->name = $data['name'] ?? '';
        $user->role = (string) ($data['role'] ?? 'Пользователь');
        $user->fav_list = (string) ($data['fav_list'] ?? []);
        $user->cart = (string) ($data['cart'] ?? []);

        $user->country = (string) ($data['country'] ?? '');
        $user->city = (string) ($data['city'] ?? '');
        $user->phone = (string) ($data['phone'] ?? '');
         
        $user->avatar = (string) ($data['avatar'] ?? '');
        $user->avatar_small = (string) $dto->avatar_small;
   
        // $user->addressId = (int) ($data['address_id'] ?? 0);
        $user->addressRepository = $data['address'];

        
        return $user;
    }

    // public function __construct(OODBBean $bean)
    // {
    //   $this->id = (int) $bean->id;
    //   $this->email = $bean->email;
    //   $this->password = $bean->password;
    //   $this->name = $bean->name ?? 'Пользователь';
    //   $this->role = $bean->role ?? 'user';

    //   // $cartData = isset($bean->cart) ? json_decode($bean->cart, true) : [];
    //   $this->cart = is_string($bean->cart) ? json_decode($bean->cart ?? '[]', true) : [];
    //   $this->fav_list = is_string($bean->fav_list) ? json_decode($bean->fav_list ?? '[]', true) : [];
    //   $this->addressId = (int) $bean->address->id ?? 0;
        
    //   $this->country= $bean->country ?? '';
    //   $this->city= $bean->city ?? '';
    //   $this->phone= $bean->phone ?? '';
    //   $this->avatar= $bean->avatar ?? '';
    //   $this->avatar_small = $bean->avatar_small ?? '';

    //   $this->addressRepository = new AddressRepository();
    // }
  

    public function getRepository(): UserRepository {
      return new UserRepository();
    }

    public function export(): array
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
          'address' => $this->getAddress(),
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

    public function getAddress(): ?Address
    {
      if (!$this->address) {
        return null; // или пустой объект / исключение
      }
      

      $addressRepository = new AddressRepository();
      return $addressRepository->getAddressById($this->addressId);
    }


}
