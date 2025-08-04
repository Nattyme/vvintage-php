<?php
declare(strict_types=1);

namespace Vvintage\DTO\User;

use Vvintage\DTO\AddressDTO;

final class UserDTO
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
    public ?AddressDTO $address = null;

    public function __construct(array $data)
    {
        $this->id = (int) ($data['id'] ?? 0);
        $this->password = (string) ($data['password'] ?? '');
        $this->email = (string) ($data['email'] ?? '');
        $this->name = (string) ($data['name'] ?? '');
        $this->role = (string) ($data['role'] ?? '');

        $this->fav_list = is_array($data['fav_list'] ?? null) ? $data['fav_list'] : json_decode($data['fav_list'] ?? '[]', true);
        $this->cart = is_array($data['cart'] ?? null) ? $data['cart'] : json_decode($data['cart'] ?? '[]', true);


        $this->country = (string) ($data['country'] ?? '');
        $this->city = (string) ($data['city'] ?? '');
        $this->phone = (string) ($data['phone'] ?? '');
        $this->avatar = (string) ($data['avatar'] ?? '');
        $this->avatar_small = (string) ($data['avatar_small'] ?? '');
        $this->addressId = (string) ($data['addressId'] ?? 0);
        
          if (isset($data['address']) && is_array($data['address'])) {
          $this->address = new AddressDTO($data['address']);
        }

    }
}
