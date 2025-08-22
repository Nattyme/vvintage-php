<?php
declare(strict_types=1);

namespace Vvintage\Services\Admin\Validation;

final class AdminProductImageValidator
{
    public array $errors = [];

  

    public function validate(array $data): array
    {
        $files = $this->isCoversExist($data) ? $data['cover'] : [];

        $images = $this->getStructuredImages($files );
   
        foreach ($images as $image) {
            $this->validateImage($image);
        }

  
        return [
          'errors' => $this->errors,
          'data' => $images
        ];
    }

    private function isCoversExist (array $data): bool
    {
      if(isset($data['cover']) && !empty($data['cover'])) {return true;}

      $this->errors['cover'][] =  'Добавьте изображения товара'; 
      return false;
    } 

    private function isFileName(array $data): void
    {
      if (isset($data['file_name']) && is_string($data['file_name']) && !empty($data['file_name'])) {return;}
      $this->errors['file_name'] = 'Имя файла обязательно';
    }

    private function isFileSize(array $data): void
    {
      if (isset($data['size']) && $data['size'] <= 12 * 1024 * 1024) { return;}

      $this->errors['size'] = 'Размер изображения превышает 12МБ';
    }

    private function isFileType(array $data): void
    {
      if (isset($data['file_name']) && preg_match("/\.(gif|jpg|jpeg|png)$/i", $data['file_name'])) {return;}
      $this->errors['type'] = 'Недопустимый формат файла. Файл изображения должен быть в формате gif, jpg, jpeg или png. ';
    }

    private function getStructuredImages(array $files): array 
    {
      $images = [];

      for ($i = 0; $i < count($files['name'] ?? []); $i++) {
          $images[] = [
              'file_name' => $files['name'][$i],
              'tmp_name' => $files['tmp_name'][$i],
              'type'     => $files['type'][$i],
              'size'     => $files['size'][$i],
              'error'    => $files['error'][$i],
              'image_order' => $i 
          ];
      }

      return $images;

    }

    private function validateImage(array $image): void
    {
        $this->isFileName($image);
        $this->isFileSize($image);
        $this->isFileType($image);
    }


}
