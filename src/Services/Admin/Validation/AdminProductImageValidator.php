<?php
declare(strict_types=1);

namespace Vvintage\Services\Admin\Validation;

final class AdminProductImageValidator
{
    public array $errors = [];


    public function validate(array $data, array $existing_images=[]): array
    {
     
        $files = $this->isCoversExist($data, $existing_images) ? $data : [];
     
        foreach ($files as $file) {
            $this->validateImage($file);
        }
       
        return [
          'errors' => $this->errors,
          'data' =>  $files
        ];
    }

    private function isCoversExist(array $data, array $existing_images = []): bool
    {
        $hasNewFiles = !empty($data);
        // $hasNewFiles = isset($data['cover']) && !empty($data['cover']['name'][0]);
        $hasExisting = !empty($existing_images);

        if ($hasNewFiles || $hasExisting) {
            return true; // файлы есть, ошибок нет
        }

        $this->errors['cover'][] = 'Добавьте изображения товара';
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
      if (isset($data['file_name']) && preg_match("/\.(gif|jpg|jpeg|webp|png)$/i", $data['file_name'])) {return;}
      $this->errors['type'] = 'Недопустимый формат файла. Файл изображения должен быть в формате gif, jpg, jpeg или png. ';
    }

    private function getStructuredImages(array $files): array 
    {
      $images = [];

       // AdminProductImageValidator (или helper)
      foreach ($files as $key => $file) {
          if (isset($file['name']) && !is_array($file['name'])) {
              // оборачиваем в массив
              foreach (['name', 'type', 'tmp_name', 'error', 'size'] as $field) {
                  $file[$field] = [$file[$field]];
              }
              $files[$key] = $file;
          }
      }

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
