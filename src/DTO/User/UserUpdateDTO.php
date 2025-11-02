<?php
declare(strict_types=1);

namespace Vvintage\DTO\User;

final class UserUpdateDTO
{
    public string $name;
    public string $surname;

    public string $country;
    public string $city;
    public string $phone;

    public ?string $avatar;
    public ?string $avatar_small;

    public function __construct(array $data)
    {
        $this->name = (string) ($data['name'] ?? '');
        $this->surname = (string) ($data['surname'] ?? '');

        $this->country = (string) ($data['country'] ?? '');
        $this->city = (string) ($data['city'] ?? '');
        $this->phone = (string) ($data['phone'] ?? '');
        $this->avatar = (string) $data['avatar'] ?? null;
        $this->avatar_small = (string) $data['avatar_small'] ?? null;
    }
}
