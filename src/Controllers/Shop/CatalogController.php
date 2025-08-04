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
use Vvintage\Models\Shop\Catalog;

/** Сервисы */
use Vvintage\Services\Product\ProductImageService;
use Vvintage\Services\Page\Breadcrumbs;

require_once ROOT . "./libs/functions.php";



final class CatalogController extends BaseController
{
    private Breadcrumbs $breadcrumbsService;

    public function __construct(Breadcrumbs $breadcrumbs)
    {
      parent::__construct(); // Важно!
      $this->breadcrumbsService=$breadcrumbs;
    }

    public function index(RouteData $routeData): void
    {
      $productRepository = new ProductRepository();

      // Название страницы
      $pageTitle = 'Каталог товаров';

      $productsPerPage = 9;
        
      // Получаем параметры пагинации
      $pagination = pagination($productsPerPage, 'products');

      // Получаем продукты с учётом пагинации
      $products = Catalog::getAll($pagination);

      $imageService = new ProductImageService();

      $imagesByProductId = [];

      foreach ($products as $product) {
          $imagesMainAndOthers = $imageService->splitImages($product->getImages());
          $imagesByProductId[$product->getId()] = $imagesMainAndOthers;
      }

      // Считаем, сколько всего товаров в базе (для отображения "Показано N из M")
      $total = $productRepository->getAllProductsCount();
      
      // Это кол-во товаров, показанных на этой странице
      // $shownProducts = $totalProducts - count($products);
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
