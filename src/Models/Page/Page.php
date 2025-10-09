<?php
declare(strict_types=1);

namespace Vvintage\Models\Page;

use RedBeanPHP\OODBBean; // для обозначения типа даннных


final class Page
{
  private int $id;
  private string $slug;
  private string $title;
  private string $content;
  private bool $visible;
  private ?array $translations;

  private ?array $fields;

  public function __construct (OODBBean $bean) {
    $this->id = (int) $bean->id;
    $this->slug = $bean->slug ?? '404';
    $this->title = $bean->title ?? 'Старница не найдена.';
    $this->content = $bean->content ?? 'Ошибка 404. Старница не найдена.';
    $this->visible = (bool) ($bean->visible ?? false);
  }

  public function getId(): int
  {
    return $this->id;
  }

  public function getSlug(): string
  {
    return $this->slug;
  }

  public function getTitle(): string
  {
    if ($this->title === '') {
      return 'Ошибка 404. Страница не найдена';
    }

    return $this->title;
  }

  public function getCurrentTranslations(): array
  {
    return $this->translations ?? [];
  }
  
  public function setFields ($fields):void
  {
    $this->fields = $fields;
  }

  public function setTranslations(array $translations): void 
  {
    $this->translations = $translations;
  }

  public function getFields(): array
  {
    return $this->fields;
  }


  /** 
   * Метод возвращает данные страницы в виде массива
   * @return array
   */
  public function export(): array 
  {
      return [
        'id' => $this->id,
        'slug' => $this->slug,
        'title' => $this->title,
        'content' => $this->content,
        'visible' => $this->visible
      ];
  }

  public function exportWithFields(): array 
  {
      return [
        'id' => $this->id,
        'slug' => $this->slug,
        'title' => $this->title,
        'content' => $this->content,
        'visible' => $this->visible,
        'fields' => $this->fields
      ];
  }

  public function getFieldsValue(string $name):? string 
  {
    foreach($this->fields as $field) {
      if($field->getName() === $name) {
        return $field->getValue();
      }
    }

    return null;
  }

  public function getFieldsAssoc(): array {
      $assoc = [];
      foreach ($this->fields as $field) {
          $assoc[$field['name']] = $field['value'];
      }
      return $assoc;
  }

}