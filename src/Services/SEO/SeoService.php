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

  public function getSeoForPage(string $pageType, $dto = null): SeoDTO
  {
      $lang = $this->currentLang;

      switch ($pageType) {
          case 'home':
              $strategy = new HomePageSeoStrategy($model, $lang);
              break;
          case 'catalog':
              $strategy = new CatalogSeoStrategy($model, $lang);
              break;
          case 'product':
              $strategy = new ProductSeoStrategy($dto, $lang);
              break;
          case 'about':
              $strategy = new ProductSeoStrategy($model);
              break;
          case 'delivery':
              $strategy = new ProductSeoStrategy($model);
              break;
          case 'profile':
              $strategy = new ProductSeoStrategy($model);
              break;
          case 'cart':
              $strategy = new ProductSeoStrategy($model);
              break;
          case 'favorites':
              $strategy = new ProductSeoStrategy($model);
              break;
          case 'post':
              $strategy = new PostSeoStrategy($model, $lang);
              break;
          default:
              throw new \Exception('Unknown SEO page type');
      }

      return $strategy->getSeo();
  }
}
