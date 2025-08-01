<?php
declare(strict_types=1);

namespace Vvintage\Models\Brand;


use RedBeanPHP\OODBBean;

final class Brand
{
    private int $id;
    private string $title;
    private ?string $image;

    private function __construct() {}
    
    public static function fromBean(OODBBean $bean): self
    {
        $brand = new self();
        $brand->id = (int) $bean->id;
        $brand->title = (string) $bean->title;
        $brand->image = (string) $bean->image;
        
        return $brand;
    }

    public static function fromArray(array $data): self
    {
        $brand = new self();
        $brand->id = (int) $data['id'];
        $brand->title = (string) $data['title'];
        $brand->image = (string) $data['image'];
        
        return $brand;
    }
    
    // Геттеры 
    public function getId(): int
    {
      return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getImage(): string
    {
      return $this->image;
    }
}
