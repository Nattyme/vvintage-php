<?php

declare(strict_types=1);

namespace Vvintage\Controllers\Shop;

/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;
use Vvintage\Repositories\ProductRepository;
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
dd($product);
        if (!$product) {
            http_response_code(404);
            echo 'Товар не найден';
            return;
        }
    
        // $imagesTotal = $product->getImagesTotal();
        $images = $product->getGalleryVars();
        $relatedProducts = $product->getRelated();

        // Название страницы
        $pageTitle = $product->getTitle();

        // Хлебные крошки
        $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);

        // Подключение шаблонов страницы
        $this->renderLayout('shop/product', [
              'pageTitle' => $pageTitle,
              'routeData' => $routeData,
              'breadcrumbs' => $breadcrumbs,
              'product' => $product,
              'images' => $images,
              'relatedProducts' => $relatedProducts
        ]);
    }
}
