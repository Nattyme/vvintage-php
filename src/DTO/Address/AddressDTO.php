<?php
declare(strict_types=1);

namespace Vvintage\DTO\Address;

final class AddressDTO
{
    public int $id;

    public string $name;
    public string $surname;
    public string $fathername;
    public string $phone;

    public string $country;
    public string $city;
    public string $area;
    public string $street;
    public string $building;
    public string $flat;
    public string $post_index;


    public function __construct(array $data)
    {
        $this->id = (int) ($data['id'] ?? 0);

        $this->name = (string) ($data['name'] ?? '');
        $this->surname = (string) ($data['surname'] ?? '');
        $this->fathername = (string) ($data['fathername'] ?? '');
        $this->phone = (string) ($data['phone'] ?? '');

        $this->country = (string) ($data['country'] ?? '');
        $this->city = (string) ($data['city'] ?? '');
        $this->area = (string) ($data['area'] ?? '');

        $this->street = (string) ($data['street'] ?? '');
        $this->building = (string) ($data['building'] ?? '');
        $this->flat = (string) ($data['flat'] ?? '');

        $this->post_index = (string) ($data['post_index'] ?? '');
       
    }
}
