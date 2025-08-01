<?php
declare(strict_types=1);


namespace Vvintage\Contracts;

interface SeoStrategyInterface
{
    public function getSeo(): SeoDTO;
}
