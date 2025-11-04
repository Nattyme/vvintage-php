<?php

declare(strict_types=1);

namespace Vvintage\public\Controllers\Shop;

use Vvintage\Routing\RouteData;

/** Контракты */
use Vvintage\Contracts\Bramd\BrandRepositoryInterface;

/** Базовый контроллер страниц*/
use Vvintage\public\Controllers\Base\BaseController;

/** Модель */
use Vvintage\Models\Product\Product;

/** Сервисы */
use Vvintage\Services\Product\ProductService;
use Vvintage\Services\Page\Breadcrumbs;
use Vvintage\Services\Seo\SeoService;
use Vvintage\DTO\Product\ProductPageDTO;
use Vvintage\Services\Page\PageService;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Session\SessionService;



final class ProductController extends BaseController
{
    protected ProductService $productService;
    protected SeoService $seoService;
    private Breadcrumbs $breadcrumbsService;
    protected PageService $pageService;

    public function __construct(
      FlashMessage $flash,
      SessionService $sessionService,
      SeoService $seoService, 
      Breadcrumbs $breadcrumbs
    )
    {
      $this->productService = new ProductService();
      $this->seoService = $seoService;
      $this->breadcrumbsService = $breadcrumbs;
      $this->pageService = new PageService();
      parent::__construct($flash, $sessionService, $this->pageService, $this->seoService); // Важно!
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
