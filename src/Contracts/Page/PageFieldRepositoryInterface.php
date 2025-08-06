<?php
declare(strict_types=1);

namespace Vvintage\Contracts\Page;

use Vvintage\Models\Page\PageField;

interface PageFieldRepositoryInterface
{    
  public static function getFieldsByPageId (): array;

  public static function saveFields (int $id, array $pageFields): void;
  
}
