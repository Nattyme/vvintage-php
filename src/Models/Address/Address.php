<?php
declare(strict_types=1);

namespace Vvintage\Models\Address;

use RedBeanPHP\OODBBean;

final class Address 
{
    private int $id;
    private int $user_id;
    private string $name;
    private string $surname;
    private string $fathername;
    private string $country;
    private string $area;
    private string $city;
    private string $street;
    private string $building;
    private string $flat;
    private string $post_index;
    private string $phone;

    public function __construct(OODBBean $bean)
    {
        $this->id = (int) $bean->id;
        $this->user_id = (int) $bean->user_id;
        $this->name = (string) $bean->name;
        $this->surname = (string) $bean->surname;
        $this->fathername = (string) $bean->fathername;
        $this->country = (string) $bean->country;
        $this->area = (string) $bean->area;
        $this->city = (string) $bean->city;
        $this->street = (string) $bean->street;
        $this->building = (string) $bean->building;
        $this->flat = (string) $bean->flat;
        $this->post_index = (string) $bean->post_index;
        $this->phone = (string) $bean->phone;
    }

    public static function fromArray(array $data): self
    {
        $address = new self();
        $address->id = (int) ($data['id'] ?? 0);
        $address->user_id = (int) ($data['user_id'] ?? 0);

        $address->name = (string) ($data['name'] ?? '');
        $address->surname = (string) ($data['surname'] ?? '');
        $address->fathername = (string) ($data['fathername'] ?? '');
        $address->phone = (string) ($data['phone'] ?? '');

        $address->country = (string) ($data['country'] ?? '');
        $address->area = (string) ($data['area'] ?? '');
        $address->city = (string) ($data['city'] ?? '');
        $address->street = (string) ($data['street'] ?? '');
        $address->building = (string) ($data['building'] ?? '');
        $address->flat = (string) ($data['flat'] ?? '');
        $address->post_index = (string) ($data['post_index'] ?? '');
        
        return $address;
    }

    public static function fromDTO(AddressDTO $dto): self
    {
        $address = new self();
        $address->id = $dto->id;
        $address->user_id = 0; // или передавай отдельно, если нужно
        $address->name = $dto->name;
        $address->surname = $dto->surname;
        $address->fathername = $dto->fathername;
        $address->country = $dto->country;
        $address->area = $dto->area;
        $address->city = $dto->city;
        $address->street = $dto->street;
        $address->building = $dto->building;
        $address->flat = $dto->flat;
        $address->post_index = $dto->post_index;
        $address->phone = $dto->phone;

        return $address;
    }


    // public function export(): array
    // {
    //     return [
    //         'id' => $this->id,
    //         'user_id' => $this->user_id,
    //         'name' => $this->name,
    //         'surname' => $this->surname,
    //         'fathername' => $this->fathername,
    //         'country' => $this->country,
    //         'area' => $this->area,
    //         'city' => $this->city,
    //         'street' => $this->street,
    //         'building' => $this->building,
    //         'flat' => $this->flat,
    //         'post_index' => $this->post_index,
    //         'phone' => $this->phone,
    //     ];
    // }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getFathername(): string
    {
        return $this->fathername;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getArea(): string
    {
        return $this->area;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getBuilding(): string
    {
        return $this->building;
    }

    public function getFlat(): string
    {
        return $this->flat;
    }

    public function getPostIndex(): string
    {
        return $this->post_index;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }
}
