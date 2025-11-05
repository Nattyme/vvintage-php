<?php
declare(strict_types=1);


namespace Vvintage\Contracts;

use Vvintage\Public\DTO\Common\SeoDTO;


interface SeoStrategyInterface
{
    public function getSeo(): SeoDTO;
}
