<?php
declare(strict_types=1);

namespace Vvintage\Public\Services\SEO;

use Vvintage\Public\DTO\Common\SeoDTO;
use Vvintage\Public\Services\SEO\ProductSeoStrategy;
use Vvintage\Public\Services\SEO\PostSeoStrategy;
use Vvintage\Public\Services\SEO\StaticPageSeoStrategy;
use Vvintage\Public\Services\Base\BaseService;


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
              $strategy = new HomePageSeoStrategy($model, $lang);
              break;
          case 'catalog':
              $strategy = new CatalogSeoStrategy($model, $lang);
              break;
          case 'product':
              $strategy = new ProductSeoStrategy($model, $lang);
              break;
          // case 'about':
          //     $strategy = new ProductSeoStrategy($model);
          //     break;
          // case 'delivery':
          //     $strategy = new ProductSeoStrategy($model);
          //     break;
          case 'profile':
          case 'profile-edit':
          case 'about':
          case 'cart':
          case 'login':
          case 'registration':
          case 'resetpass':
          case 'setnewpass':
              $strategy = new StaticPageSeoStrategy($model, $lang);
              break;
          // case 'cart':
          //     $strategy = new ProductSeoStrategy($model);
          //     break;
          // case 'favorites':
          //     $strategy = new ProductSeoStrategy($model);
          //     break;
          // case 'post':
          //     $strategy = new PostSeoStrategy($model, $lang);
          //     break;
          default:
              throw new \Exception('Unknown SEO page type');
      }

      return $strategy->getSeo();
  }
}
