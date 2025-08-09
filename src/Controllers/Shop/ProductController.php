<?php

declare(strict_types=1);

namespace Vvintage\Controllers\Shop;

use Vvintage\Routing\RouteData;

/** Контракты */
use Vvintage\Contracts\Bramd\BrandRepositoryInterface;

/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;

/** Репозитории */
// use Vvintage\Repositories\Product\ProductRepository;

/** Модель */
use Vvintage\Models\Product\Product;

/** Сервисы */
use Vvintage\Services\Product\ProductImageService;
use Vvintage\Services\Product\ProductService;
use Vvintage\Services\Page\Breadcrumbs;
use Vvintage\Services\Seo\SeoService;



final class ProductController extends BaseController
{
    private ProductService $productService;
    private Breadcrumbs $breadcrumbsService;

    public function __construct(ProductService  $productService, Breadcrumbs $breadcrumbs)
    {
        parent::__construct(); // Важно!
        $this->productService = $productService;
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

        // Инициализируем SEO-сервис и получаем SEO DTO
        $seoService = new SeoService();
        $seo = $seoService->getSeoForPage('product', $product);

        // Делим массив изображений на два массива - главное и другие
        $imagesMainAndOthers = $this->productService->getProductImages($product);
        $totalImages = $this->productService->countImages( $product->getImages() );
    
        // Получаем похожие продукты
        $related = $product->getRelated();
        $gallery = $this->productService->splitVisibleHidden($imagesMainAndOthers['others']);

        // Формируем единую модель для передачи в шаблон
        $productViewModel = [
            'product' => $product,
            'imagesTotal' =>  $totalImages,
            'main' => $imagesMainAndOthers['main'],
            'gallery' => $gallery, 
            'related' => $related,
        ];

        // Название страницы
        $pageTitle = $product->getTitle();

        // Хлебные крошки
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
