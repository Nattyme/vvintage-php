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

  public function __construct (OODBBean $bean) {
    $this->id = (int) $bean->id;
    $this->slug = $bean->slug ?? '404';
    $this->title = $bean->title ?? 'Старница не найдена.';
    $this->content = $bean->content ?? 'Ошибка 404. Старница не найдена.';
    $this->visible = (bool) ($bean->visible ?? false);
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


  public function getId(): int
  {
      return $this->id;
  }
}