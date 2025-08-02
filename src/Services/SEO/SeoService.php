<?php
declare(strict_types=1);

namespace Vvintage\Services\SEO;

use Vvintage\Services\SEO\ProductSeoStrategy;
// use Vvintage\Services\SEO\ProductSeoStrategy;

class SeoService
{
    public function getSeoForPage(string $pageType, $model = null): SeoDTO
    {
        switch ($pageType) {
            case 'home':
                $strategy = new HomePageSeoStrategy();
                break;
            case 'product':
                $strategy = new ProductSeoStrategy($model);
                break;
            default:
                throw new \Exception('Unknown SEO page type');
        }

        return $strategy->getSeo();
    }
}
