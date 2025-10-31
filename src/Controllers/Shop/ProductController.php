<?php

declare(strict_types=1);

namespace Vvintage\Controllers\Shop;

use Vvintage\Routing\RouteData;

use Vvintage\Models\Product\Product; /** Модель */
use Vvintage\Controllers\Base\BaseController; /** Базовый контроллер страниц*/
use Vvintage\Contracts\Bramd\BrandRepositoryInterface; /** Контракт */

/** Сервисы */
use Vvintage\Services\Product\ProductService;
use Vvintage\Services\Page\Breadcrumbs;
use Vvintage\Services\Seo\SeoService;
use Vvintage\DTO\Product\ProductPageDTO;
use Vvintage\Services\Page\PageService;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Session\SessionService;
use Vvintage\Services\AdminPanel\AdminPanelService;



final class ProductController extends BaseController
{
    private ProductService $productService;
    private SeoService $seoService;
    private Breadcrumbs $breadcrumbsService;
    private PageService $pageService;
    private FlashMessage $flash;

    public function __construct(
      SessionService $sessionService, 
      AdminPanelService $adminPanelService,
      PageService $pageService, 
      ProductService $productService, 
      FlashMessage $flash, 
      SeoService $seoService, 
      Breadcrumbs $breadcrumbs
    )
    {
        parent::__construct($sessionService, $adminPanelService); // Важно!
        $this->productService = $productService;
        $this->seoService = $seoService;
        $this->breadcrumbsService = $breadcrumbs;
        $this->pageService = $pageService;
        $this->flash = $flash;
    }


    public function index(RouteData $routeData): void
    {   
        $this->setRouteData($routeData);
  
        $id = (int) $routeData->uriGet; // получаем id товара из URL  
        $productPageData = $this->productService->getProductPageData($id);

        if (empty($productPageData) ||!$productPageData['dto']) {
            http_response_code(404);
            echo 'Товар не найден';
            return;
        }
   
        // $related = $product->getRelated();
        $statusList = $this->productService->getStatusList();

        $productDto = $productPageData['dto'];

        // Формируем единую модель для передачи в шаблон
        $viewModel = [
            'product' => $productPageData['dto'],
            'imagesTotal' => $productDto->images['total'],
            'main' => $productDto->images['main'],
            'gallery' => $productDto->images['gallery'], 
            // 'related' => $related,
            'statusList'=> $statusList,
        ];

        // Название страницы и хлебные крошки
        $breadcrumbs = $this->breadcrumbsService->generate($routeData, $productDto->title);

  
        $seo = $this->seoService->getSeoForPage('product', $productPageData['product']);
        $pageTitle = $productDto->title;

        // Подключение шаблонов страницы
        $this->renderLayout('shop/product', [
              'pageTitle' => $pageTitle,
              'seo' => $seo,
              'currentLang' => $this->productService->currentLang,
              'routeData' => $routeData,
              'navigation' => $this->pageService->getLocalePagesNavTitles(),
              'breadcrumbs' => $breadcrumbs,
              'viewModel' => $viewModel,
              'flash' => $this->flash,
              'currentLang' =>  $this->pageService->currentLang,
              'languages' => $this->pageService->languages
        ]);
    }
}
