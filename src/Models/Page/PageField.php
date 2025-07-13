<?php
declare(strict_types=1);

namespace Vvintage\Models\Page;

use RedBeanPHP\OODBBean; // для обозначения типа даннных


final class PageField
{
  private int $id;
  private int $pages_id;
  private string $name;
  private string $value;

  public function __construct (OODBBean $bean) {

    $this->id = (int) $bean->id;
    $this->pages_id = (int) $bean->pages_id;
    $this->name = $bean->name ?? 'Старница не найдена.';
    $this->value = $bean->value ?? 'Ошибка 404. Старница не найдена.';
  }

  /** 
   * Метод возвращает данные поля в виде массива
   * @return array
   */
  public function export(): array 
  {
      return [
        'id' => $this->id,
        'pages_id' => $this->pages_id,
        'name' => $this->name,
        'value' => $this->value,
      ];
  }


  public function getId(): int
  {
      return $this->id;
  }

  public function getValue(): string
  {
    return $this->value;
  }

  public function getName(): string 
  {
    return $this->name;
  }
}