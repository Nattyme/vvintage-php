<?php

declare(strict_types=1);

namespace Vvintage\Controllers\Shop;

use Vvintage\Routing\RouteData;

/** Контракты */
use Vvintage\Contracts\Bramd\BrandRepositoryInterface;

/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;

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
    private ProductService $productService;
    private SeoService $seoService;
    private Breadcrumbs $breadcrumbsService;
    private PageService $pageService;

    public function __construct(
      FlashMessage $flash,
      SessionService $sessionService,
      SeoService $seoService, 
      Breadcrumbs $breadcrumbs
    )
    {
        parent::__construct($flash, $sessionService); // Важно!
        $this->productService = new ProductService();
        $this->seoService = $seoService;
        $this->breadcrumbsService = $breadcrumbs;
        $this->pageService = new PageService();
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
