<?php
declare(strict_types=1);

namespace Vvintage\DTO\User;

final class UserCreateDTO
{
    public string $password;
    public string $email;
    public string $name;
    public string $surname;
    public string $role;

    public array $fav_list;
    public array $cart;

    public string $country;
    public string $city;
    public string $phone;

    public string $avatar;
    public string $avatar_small;

    public function __construct(array $data)
    {
        $this->password = (string) ($data['password'] ?? '');
        $this->email = (string) ($data['email'] ?? '');
        $this->name = (string) ($data['name'] ?? '');
        $this->surname = (string) ($data['surname'] ?? '');
        $this->role = 'customer';

        $this->fav_list = is_array($data['fav_list'] ?? null) ? $data['fav_list'] : json_decode($data['fav_list'] ?? '[]', true);
        $this->cart = is_array($data['cart'] ?? null) ? $data['cart'] : json_decode($data['cart'] ?? '[]', true);


        $this->country = (string) ($data['country'] ?? '');
        $this->city = (string) ($data['city'] ?? '');
        $this->phone = (string) ($data['phone'] ?? '');
        $this->avatar = (string) ($data['avatar'] ?? '');
        $this->avatar_small = (string) ($data['avatar_small'] ?? '');

    }
}
