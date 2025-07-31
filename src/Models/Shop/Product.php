<?php

declare(strict_types=1);

namespace Vvintage\Models\Shop;

use Vvintage\DTO\Product\ProductDTO;
use Vvintage\DTO\Category\CategoryDTO;
use Vvintage\Models\Category\Category;

require_once ROOT . "./libs/functions.php";

class Product
{
    private int $id;
    private int $category_id;  
    private string $category_title;  
    private Category $category;  
    private int $brand_id;
    private string $brand_title;
    private string $slug;
    private string $title;
    private string $content;
    private string $price;
    private string $url;
    private string $article;
    private int $stock;
    private string $datetime;
    private ?array $images;      // массив изображений
    private ?int $imagesTotal;

    private array $translations;
    private string $seoTitle;
    private string $seoDescription;

    private string $currentLocale = 'ru';

    private function __construct() {}

    public static function fromDTO(ProductDTO $dto): self
    {
      $product = new self();

      $product->id = $dto->id;
      $product->category_id = $dto->category_id;
      $product->category_title = $dto->category_title;
      $product->category = Category::fromDTO($dto->categoryDTO);
      $product->brand_id = $dto->brand_id;
      $product->brand_title = $dto->brand_title;
      $product->slug = $dto->slug;
      $product->title = $dto->title;
      $product->content = $dto->content;
      $product->price = $dto->price;
      $product->url = $dto->url;
      $product->article = $dto->article;
      $product->stock = $dto->stock;
      $product->datetime = $dto->datetime;

      $product->images = $dto->images;
      $product->imagesTotal = $dto->imagesTotal;

      $product->translations = $dto->translations;
      $product->seoTitle = $dto->seoTitle;
      $product->seoDescription = $dto->seoDescription;

      return $product;
    }

    public static function fromArray(array $data): self
    {
      $product = new self();
      $product->id = (int) ($data['id'] ?? 0);
      $product->category_id = (int) ($data['category_id'] ?? 0);
      $product->brand_id = (int) ($data['brand_id'] ?? '');
      $product->brand_title = (int) ($data['brand_title'] ?? '');
      $product->slug = (string) ($data['slug'] ?? '');
      $product->title = (string) ($data['title'] ?? '');
      $product->content = (string) ($data['content'] ?? '');
      $product->price = (string) ($data['price'] ?? '');
      $product->url = (string) ($data['url'] ?? '');
      $product->article =  (string) ($data['article'] ?? '');
      $product->stock =  (int) ($data['stock'] ?? 0);
      $product->datetime =  (string) ($data['datetime'] ?? '');

      $product->images = $data['images'] ?? [];
      // $product->imagesTotal = $dto->imagesTotal;

      $product->translations = $data['translations'] ?? [];
      $product->seoTitle = (string) ($data['seo_title'] ?? '');
      $product->seoDescription = (string) ($data['seo_description'] ?? '');
      $product->currentLocale = (string) ($data['locale'] ?? 'ru');

      return $product;
    }

    // public function loadFromArray(array $row): void
    // {
    //     $this->id = (int) $row['id'];
    //     $this->title = $row['title'];
    //     $this->price = (float)$row['price'];

    //     // Опциональные поля
    //     $this->content = $row['content'] ?? '';
    //     $this->category = $row['cat_title'] ?? '';
    //     $this->brand = $row['brand_title'] ?? '';
    //     $this->url = (string)$row['url'];
    //     $this->datetime = (string) $row['datetime'];
    //     $this->getImages();
    // }

    public function getMainImage(): ?string
    {
        $this->getImages(); // на случай, если изображения ещё не загружены
        return $this->images[0] ?? null;
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
dd($this->getImages());
        // Найдем изображения для галлереи
        $visibleImages = array_slice($this->images['others'], 0, 4);
        $hiddenImages = array_slice($this->images['others'], 4);

        $galleryVars = ['visible' =>  $visibleImages, 'hidden' => $hiddenImages];

        return  $galleryVars;
    }

    // Ф-ция возвращает похожие продукты
    public function getRelated(): array
    {
        return get_related_products($this->title, $this->brand_title, $this->category);
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

    public function getBrand(): int
    {
        return $this->brand_id;
    }

    public function getUrl(): string
    {
      return $this->url;
    }

    public function getPrice(): string
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

    public function getCategory(): int
    {
      return $this->category_id;
    }

    public function getCategoryTitle(): string {
        return $this->category->getTitle();
    }

}
