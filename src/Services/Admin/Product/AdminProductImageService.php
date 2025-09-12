<?php
declare(strict_types=1);

namespace Vvintage\Services\Admin\Product;

use Vvintage\DTO\Product\ProductImageDTO;
use Vvintage\Services\Product\ProductImageService;

require_once ROOT . "./libs/functions.php";

final class AdminProductImageService extends ProductImageService
{
    private string $tmpFolder;
    private string $finalFolder;

    public function __construct()
    {
        parent::__construct();
        $this->tmpFolder   = ROOT . 'usercontent/tmp/product_images/';
        $this->finalFolder = ROOT . 'usercontent/products/';

        if (!file_exists($this->tmpFolder)) {
            mkdir($this->tmpFolder, 0755, true);
        }
        if (!file_exists($this->finalFolder)) {
            mkdir($this->finalFolder, 0755, true);
        }
    }


        /**
     * Подготавливает изображения: грузит в tmp + делает ресайзы
     */
    public function prepareImages(array $files, array $sizes): array
    {
   
        $processed = [];
        //  $coverImages = saveSliderImg('cover', [350, 478], 12, 'products', [536, 566], [350, 478]);
        foreach ($files as $file) {
            $tmpName = $file['tmp_name'];
            $kaboom = explode(".", $file['file_name']);
            $fileExt = end($kaboom);

            // Генерация уникального имени (без дублей)
            $baseName = rand(100000000000,999999999999) . "." . $fileExt;
            $tmpFile  = $this->tmpFolder . $baseName;

            if (!move_uploaded_file($tmpName, $tmpFile)) {
                throw new \RuntimeException("Не удалось загрузить файл {$tmpName} во временную папку");
            }

            // Генерация разных размеров
            $fullTmp  = $this->tmpFolder . 'full_' . $baseName;;
            $smallTmp = $this->tmpFolder . 'small_' . $baseName;

            resize_and_crop($tmpFile, $fullTmp,  $sizes['full'][0],  $sizes['full'][1]);
            resize_and_crop($tmpFile, $smallTmp, $sizes['small'][0], $sizes['small'][1]);

            // исходник tmp больше не нужен → сразу удаляем
            @unlink($tmpFile);

            $processed[] = [
                'tmp_full'       => $fullTmp,
                'tmp_small'      => $smallTmp,
                'original_name'  => $tmpName,
                'final_full'     => $baseName,
                'final_small'    => $sizes['small'][0] . '-' . $baseName,
            ];
        }
        return $processed;
    }

    public function updateExistImages(int $id, array $images): void 
    {
      // error_log(print_r( $images, true));
      $newIds = array_map(fn($img) => $img['id'], $images);

      // Получим все изображения продука из БД по id
      $imagesDB = $this->repository->getAllImages($id);
      $existingIds = array_map(fn($img) => $img->id, $imagesDB);

      // Получаем список id, которых нет в новом массиве
      $idsToDelete = array_diff($existingIds, $newIds);

      // Удаляем лишние
      $this->repository->removeImagesByIds($idsToDelete);
    }


  

    /**
     * Финализируем: переносим tmp → products
     */
    public function finalizeImages(array $images): array
    {
        $finalPaths = [];

        foreach ($images as $img) {
            $finalFull  = $this->finalFolder . $img['final_full'];
            $finalSmall = $this->finalFolder . $img['final_small'];

            if (!rename($img['tmp_full'], $finalFull)) {
                throw new \RuntimeException("Не удалось переместить full для {$img['original_name']}");
            }
            if (!rename($img['tmp_small'], $finalSmall)) {
                throw new \RuntimeException("Не удалось переместить small для {$img['original_name']}");
            }

            $finalPaths[] = [
                'filename'  => basename($finalFull),
                'filename_small' => basename($finalSmall),
            ];
        }

        return $finalPaths;
    }

    /**
     * Удаляет tmp-версии
     */
    public function cleanup(array $images): void
    {
        foreach ($images as $img) {
            @unlink($img['tmp_full']);
            @unlink($img['tmp_small']);
        }
    }

    /**
     * Удаляет уже перемещённые финальные версии
     */
    public function cleanupFinal(array $images): void
    {
        foreach ($images as $img) {
            @unlink($this->finalFolder . $img['filename']);
            @unlink($this->finalFolder . $img['filename_small']);
        }
    }

    public function deleteImagesNotInList (int $productId, array $keepIds): void 
    {
      $this->repository->deleteImagesNotInList($productId, $keepIds);
    }
    
    public function updateImagesOrder(int $productId, array $images): void 
    {
      $this->repository->updateImagesOrder($productId, $images);
    }

}
