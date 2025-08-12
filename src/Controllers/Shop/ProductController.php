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



final class ProductController extends BaseController
{
    private ProductService $productService;
    private SeoService $seoService;
    private Breadcrumbs $breadcrumbsService;

    public function __construct(ProductService  $productService, SeoService $seoService, Breadcrumbs $breadcrumbs)
    {
        parent::__construct(); // Важно!
        $this->productService = $productService;
        $this->seoService = $seoService;
        $this->breadcrumbsService = $breadcrumbs;
    }


    public function index(RouteData $routeData): void
    {   
        $this->setRouteData($routeData);
     
        $id = (int) $routeData->uriGet; // получаем id товара из URL  
        $product = $this->productService->getProductById($id);

        if (!$product) {
            http_response_code(404);
            echo 'Товар не найден';
            return;
        }

        $seo = $this->seoService->getSeoForPage('product', $product);
        $productImagesData = $this->productService->getProductImagesData($product->getImages());
        $related = $product->getRelated();
        $statusList = $this->productService->getStatusList();

        // Формируем единую модель для передачи в шаблон
        $productViewModel = [
            'product' => $product,
            'imagesTotal' =>  $productImagesData['total'],
            'main' => $productImagesData['main'],
            'gallery' => $productImagesData['gallery'], 
            'related' => $related,
            'statusList'=> $statusList
        ];

        // Название страницы и хлебные крошки
        $pageTitle = $product->getTitle();
        $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);

        // Подключение шаблонов страницы
        $this->renderLayout('shop/product', [
              'pageTitle' => $pageTitle,
              'seo' => $seo,
              'routeData' => $routeData,
              'breadcrumbs' => $breadcrumbs,
              'productViewModel' => $productViewModel
        ]);
    }
}
