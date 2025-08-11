<?php 
declare(strict_types=1);

namespace Vvintage\Services\Admin;

use Vvintage\Services\Post\PostService;


final class AdminPostService extends PostService
{

    public function __construct(array $languages, string $currentLang)
    {
      parent::__construct($languages, $currentLang);
    }

}
