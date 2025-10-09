<?php
declare(strict_types=1);

namespace Vvintage\Services\SEO;

use Vvintage\DTO\Common\SeoDTO;
use Vvintage\Services\SEO\ProductSeoStrategy;
use Vvintage\Services\SEO\PostSeoStrategy;
use Vvintage\Services\Base\BaseService;
// use Vvintage\Services\SEO\ProductSeoStrategy;



/**
 * Example
 * $seoService = new SeoService();
 * $seo = $seoService->getSeoForPage('product', $product);
 * 
 */
class SeoService extends BaseService
{
  
  public function __construct() 
  {
    parent::__construct();
  }

  public function getSeoForPage(string $pageType, $model = null): SeoDTO
  {
      $lang = $this->currentLang;

      switch ($pageType) {
          case 'home':
              $strategy = new HomePageSeoStrategy();
              break;
          case 'product':
              $strategy = new ProductSeoStrategy($model);
              break;
          case 'post':
              $strategy = new PostSeoStrategy($model);
              break;
          case 'catalog':
              $strategy = new CatalogSeoStrategy($model, $lang);
              break;
          default:
              throw new \Exception('Unknown SEO page type');
      }

      return $strategy->getSeo();
  }
}
