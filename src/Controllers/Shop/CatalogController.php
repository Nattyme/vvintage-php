<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Shop;

use Vvintage\Routing\RouteData;

/** Контракты */
use Vvintage\Contracts\Repositories\BrandRepositoryInterface;

/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;
use Vvintage\Repositories\Product\ProductRepository;

/** Модели */
use Vvintage\Services\Product\ProductService;

/** Сервисы */
use Vvintage\Services\Product\ProductImageService;
use Vvintage\Services\Page\Breadcrumbs;

require_once ROOT . "./libs/functions.php";



final class CatalogController extends BaseController
{
    private ProductService $productService;
    private Breadcrumbs $breadcrumbsService;

    public function __construct(ProductService $productService, Breadcrumbs $breadcrumbs)
    {
      parent::__construct(); // Важно!
      $this->productService = $productService;
      $this->breadcrumbsService = $breadcrumbs;
    }

    public function index(RouteData $routeData): void
    {
      $this->setRouteData($routeData); // <-- передаём routeData

      // Название страницы
      $pageTitle = 'Каталог товаров';

      $productsPerPage = 9;
      
      // Получаем параметры пагинации
      $pagination = pagination($productsPerPage, 'products');

      // Получаем продукты с учётом пагинации
      $products =  $this->productService->getAll($pagination);
      $total = $this->productService->countProducts();
      $imagesByProductId = $this->productService->getProductsImages($products);

      // Это кол-во товаров, показанных на этой странице
      $shown = (($pagination['page_number'] - 1) * 9) + count($products);

      // Хлебные крошки
      $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);

      // Формируем единую модель для передачи в шаблон
      $productViewModel = [
          'products' => $products,
          'imagesByProductId' => $imagesByProductId,
          'total' => $total,
          'shown' => $shown
      ];


      // Подключение шаблонов страницы
      $this->renderLayout('shop/catalog', [
            'pagination' => $pagination,
            'pageTitle' => $pageTitle,
            'routeData' => $routeData,
            'breadcrumbs' => $breadcrumbs,
            'productViewModel' => $productViewModel
      ]);
    }
}
