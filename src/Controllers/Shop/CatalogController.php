<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Shop;


/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;
use Vvintage\Repositories\ProductRepository;

use Vvintage\Routing\RouteData;
use Vvintage\Models\Shop\Catalog;
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
      
      // Считаем, сколько всего товаров в базе (для отображения "Показано N из M")
      $totalProducts = $productRepository->countAll();
      
      // Это кол-во товаров, показанных на этой странице
      // $shownProducts = $totalProducts - count($products);
      $shownProducts = (($pagination['page_number'] - 1) * 9) + count($products);

      // Хлебные крошки
      $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);

      // Подключение шаблонов страницы
      $this->renderLayout('shop/catalog', [
            'pagination' => $pagination,
            'pageTitle' => $pageTitle,
            'routeData' => $routeData,
            'breadcrumbs' => $breadcrumbs,
            'products' => $products,
            'totalProducts' => $totalProducts,
            'shownProducts' => $shownProducts,
      ]);
    }
}
