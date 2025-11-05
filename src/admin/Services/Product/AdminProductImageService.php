<?php
declare(strict_types=1);

namespace Vvintage\Services\Admin\Product;

use Vvintage\admin\DTO\Product\ProductImageInputDTO;
use Vvintage\Services\Product\ProductImageService;

require_once ROOT . "./libs/functions.php";

final class AdminProductImageService extends ProductImageService
{
    private string $tmpFolder;
    private string $finalFolder;

    private const IMAGE_SIZES = [
        'medium' => [800, 800],
        'small'  => [350, 478]
    ];

    public function __construct()
    {
        parent::__construct();
        $this->tmpFolder   = ROOT . 'usercontent/tmp/product_images/';
        $this->finalFolder = ROOT . 'usercontent/products/';

        if (!file_exists($this->tmpFolder)) mkdir($this->tmpFolder, 0755, true);
        if (!file_exists($this->finalFolder)) mkdir($this->finalFolder, 0755, true);
    }

    public function prepareImages(array $files): array
    {
        $processed = [];

        foreach ($files as $file) {
            $tmpName = $file['tmp_name'];
            $ext = pathinfo($file['file_name'], PATHINFO_EXTENSION);

            $baseName = rand(100000000000, 999999999999) . "." . $ext;
            $tmpFile  = $this->tmpFolder . $baseName;

            if (!move_uploaded_file($tmpName, $tmpFile))  throw new \RuntimeException("Не удалось загрузить файл {$tmpName} во временную папку");
            

            // full — просто оставляем оригинал
            $fullTmp   = $tmpFile;

            // medium — обрезанный
            $mediumTmp = $this->tmpFolder . 'medium-' . $baseName;
            resize_and_crop($tmpFile, $mediumTmp, self::IMAGE_SIZES['medium'][0], self::IMAGE_SIZES['medium'][1]);

            // small — обрезанный
            $smallTmp  = $this->tmpFolder . 'small-' . $baseName;
            resize_and_crop($tmpFile, $smallTmp, self::IMAGE_SIZES['small'][0], self::IMAGE_SIZES['small'][1]);

            $processed[] = [
                'tmp_full'     => $fullTmp,
                'tmp_medium'   => $mediumTmp,
                'tmp_small'    => $smallTmp,
                'original_name'=> $file['file_name'],
                'final_full'   => $baseName,              // без префикса!
                'final_medium' => 'medium-' . $baseName,
                'final_small'  => 'small-' . $baseName,
                'image_order'  => $file['image_order'] ?? 0
            ];

        }

        return $processed;
    }

    public function finalizeImages(array $images): array
    {
      $finalPaths = [];

      foreach ($images as $img) {
          $finalFull   = $this->finalFolder . $img['final_full'];
          $finalMedium = $this->finalFolder . $img['final_medium'];
          $finalSmall  = $this->finalFolder . $img['final_small'];

          foreach (['tmp_full' => $finalFull, 'tmp_medium' => $finalMedium, 'tmp_small' => $finalSmall] as $tmp => $final) {
              if (!rename($img[$tmp], $final)) throw new \RuntimeException("Не удалось переместить {$tmp} для {$img['original_name']}");
          }

          $finalPaths[] = [
              'filename_full'   => basename($finalFull),
              'filename_medium' => basename($finalMedium),
              'filename_small'  => basename($finalSmall),
          ];
      }

      return $finalPaths;
    }

    public function cleanup(array $images): void
    {
        foreach ($images as $img) {
            foreach (['tmp_full', 'tmp_medium', 'tmp_small'] as $key) {
                if (!empty($img[$key]) && file_exists($img[$key])) {
                    @unlink($img[$key]);
                }
            }
        }
    }

    /**
     * Работает и с массивами, и с объектами DTO
     */
    public function cleanupFinal(array $images): void
    {

        foreach ($images as $img) {
            // $full   = $medium = $small = null;

            if (is_array($img)) {
                $full = $img['filename'] ?? null;
                $medium = 'medium-' . $full ?? null;
                $small  = 'small-' . $full ?? null;
            } elseif (is_object($img)) {
                $full   = $img->filename ?? null;
                $medium = 'medium-' . $full ?? null;
                $small  = 'small-' . $full ?? null;
            }

            foreach ([$full, $medium, $small] as $file) {
                if ($file && file_exists($this->finalFolder . $file)) {
                    @unlink($this->finalFolder . $file);
                }
            }
        }
    }

    // --- Остальная логика по обновлению изображений в БД ---
    public function updateExistImages(int $id, array $images): void 
    {
        $newIds = array_map(fn($img) => $img['id'], $images);
        $imagesDB = $this->repository->getAllImages($id);
        $existingIds = array_map(fn($img) => $img->id, $imagesDB);
        $idsToDelete = array_diff($existingIds, $newIds);
        $this->repository->removeImagesByIds($idsToDelete);
    }

    public function saveProductImages($id, $processedImages): void
    {
        $imagesDto = $this->buildImageDtos($id, $processedImages);
        $this->updateImages($imagesDto);
    }

    public function deleteImagesNotInList(int $productId, array $keepIds): void 
    {
        $this->repository->deleteImagesNotInList($productId, $keepIds);
    }

    public function updateImagesOrder(int $productId, array $images): void 
    {
        $this->repository->updateImagesOrder($productId, $images);
    }

    public function updateImages(array $imagesDto): void 
    {
      // Приведем к массиву перед передаче в БД
      $images = array_map(fn($image) => $image->toArray(), $imagesDto); 

      foreach ($images as $image) {
          if (!isset($image['id'])) {
              $this->repository->addImage($image);
          } else {
              $this->repository->updateImage($image['id'], $image);
          }
      }
    }

    public function createProductImageInputDTO(int $productId, array $processedImages): array
    {
        $imagesDto = [];

        foreach ($processedImages as $img) {
            if (!empty($img['id'])) {
                continue; // уже существующие изображения
            }

            if (empty($img['final_full'])) {
                continue; // пустые файлы игнорируем
            }

            $imagesDto[] = new ProductImageInputDTO([
                'product_id' => $productId,
                'filename' => $img['final_full'],
                'image_order' => $img['image_order'] ?? 0,
                'alt' => $img['alt'] ?? '',
            ]);
        }

        return $imagesDto;
    }

}
