<?php
declare(strict_types=1);

namespace Vvintage\Contracts\Page;

use Vvintage\Models\Page\PageField;

interface PageFieldRepositoryInterface
{    
  public function getFieldsByPageId (): array;

  public function saveFields (int $id, array $pageFields): void;
  
}
