<?php

declare(strict_types=1);

namespace Vvintage\Controllers\Shop;

/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;
use Vvintage\Repositories\ProductRepository;
use Vvintage\Services\Product\ProductImageService;
use Vvintage\Models\Shop\Product;
use Vvintage\Routing\RouteData;
use Vvintage\Services\Page\Breadcrumbs;


final class ProductController extends BaseController
{
    private Breadcrumbs $breadcrumbsService;

    public function __construct(Breadcrumbs $breadcrumbs)
    {
        parent::__construct(); // Важно!
        $this->breadcrumbsService = $breadcrumbs;
    }

    public function index(RouteData $routeData): void
    {   
        $id = (int) $routeData->uriGet; // получаем id товара из URL
        $productRepository = new ProductRepository();
        $product = $productRepository->findById($id);

        if (!$product) {
            http_response_code(404);
            echo 'Товар не найден';
            return;
        }

        $imageService = new ProductImageService();
        
        // Делим массив изобрадений на два массива - главное и другие
        $imagesMainAndOthers = $imageService->splitImages($product->getImages());
        $related = $product->getRelated();

        // Формируем единую модель для передачи в шаблон
        $productViewModel = [
            'product' => $product,
            'imagesTotal' => $imageService->countAll( $product->getImages() ),
            'main' => $imagesMainAndOthers['main'],
            'gallery' => $imageService->splitVisibleHidden($imagesMainAndOthers['others']),
            'related' => $related,
        ];

        // Название страницы
        $pageTitle = $product->getTitle();

        // Хлебные крошки
        $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);

        // Подключение шаблонов страницы
        $this->renderLayout('shop/product', [
              'pageTitle' => $pageTitle,
              'routeData' => $routeData,
              'breadcrumbs' => $breadcrumbs,
              'productViewModel' => $productViewModel
        ]);
    }
}
