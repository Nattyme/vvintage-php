<?php

declare(strict_types=1);

namespace Vvintage\Models\Shop;

use Vvintage\Database\Database;

require_once ROOT . "./libs/functions.php";

class Product
{
    private int $id;
    private string $title;
    private string $content;
    private string $brand;
    private string $category;
    private float $price;
    private string $datetime;
    private ?array $images = null; // изначально изображения не загружены
    private ?int $imagesTotal = null;

    public function loadFromArray(array $row): void
    {
        $this->id = (int) $row['id'];
        $this->title = $row['title'];
        $this->price = (float)$row['price'];

        // Опциональные поля
        $this->content = $row['content'] ?? '';
        $this->category = $row['cat_title'] ?? '';
        $this->brand = $row['brand_title'] ?? '';
        $this->datetime = $row['datetime'];
        $this->getImages();
    }

    public function getMainImage(): ?string
    {
        $this->getImages(); // на случай, если изображения ещё не загружены
        return $this->images['main'] ?? null;
    }


    // Ф-ция возвращает изображения продукта
    public function getImages(): array
    {
        // Если загружены изображения - возвращаем
        if ($this->images !== null) {
            return $this->images;
        }

        $main = null;
        $others = [];
        $rows = Database::getProductImagesRow($this->id);

        // Посчитаем общее кол-во изображений
        $this->imagesTotal = count($rows);

        // Обходим массив изображении продукта и находим главное. Остальные сохраняем в массив
        foreach ($rows as $row) {
            if ((int) $row['image_order'] === 1 && $main === null) {
                $main = $row['filename'];
            } else {
                $others[] = $row['filename'];
            }
        }

        $this->images = ['main' => $main, 'others' => $others];
        return $this->images;
    }

    // Ф-ция формирует массивы дляя галереи изображений
    public function getGalleryVars(): array
    {
        // Если загружены изображения - возвращаем
        if ($this->images === null) {
            $this->getImages();
        }

        // Найдем изображения для галлереи
        $visibleImages = array_slice($this->images['others'], 0, 4);
        $hiddenImages = array_slice($this->images['others'], 4);

        $galleryVars = ['visible' =>  $visibleImages, 'hidden' => $hiddenImages];

        return  $galleryVars;
    }

    // Ф-ция возвращает похожие продукты
    public function getRelated(): array
    {
        return get_related_products($this->title, $this->brand, $this->category);
    }

    /**
     * Getters
    */
    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getTimestamp(): string
    {
        return $this->datetime;
    }

    // Ленивая загрузка изображений, если они ещё не загружены
    public function getImagesTotal(): int
    {
        if ($this->imagesTotal === null) {
            $this->getImages(); // автоматически загружает изображения и считает images
        }
        return $this->imagesTotal;
    }
}
