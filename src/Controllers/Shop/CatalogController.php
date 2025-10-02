<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Shop;

use Vvintage\Routing\RouteData;

/** Контракты */
use Vvintage\Contracts\Repositories\BrandRepositoryInterface;

/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;
use Vvintage\Repositories\Product\ProductRepository;

/** Сервисы */
use Vvintage\Services\Product\ProductService;
use Vvintage\Services\Category\CategoryService;
use Vvintage\Services\Brand\BrandService;
use Vvintage\Services\Product\ProductImageService;
use Vvintage\Services\Seo\SeoService;
use Vvintage\Services\Page\Breadcrumbs;

use Vvintage\DTO\Product\ProductFilterDTO;

require_once ROOT . "./libs/functions.php";



final class CatalogController extends BaseController
{
    private ProductService $productService;
    private CategoryService $categoryService;
    private BrandService $brandService;
    private SeoService $seoService;
    private Breadcrumbs $breadcrumbsService;

    public function __construct(SeoService $seoService, Breadcrumbs $breadcrumbs)
    {
      parent::__construct(); // Важно!
      $this->productService = new ProductService();
      $this->categoryService = new CategoryService();
      $this->brandService = new BrandService();
      $this->seoService = $seoService;
      $this->breadcrumbsService = $breadcrumbs;
    }


    public function index(RouteData $routeData): void
    {
      $this->setRouteData($routeData); // <-- передаём routeData

      // Название страницы
      $pageTitle = 'Каталог товаров';
      $productsPerPage = 12;
      // $pagination = pagination($productsPerPage, 'products');
// Array
// (
//     [number_of_pages] => 5
//     [page_number] => 1
//     [sql_page_limit] => LIMIT 0, 9
// )

      $filterDto = new ProductFilterDTO([
          'brands'    => $_GET['brand'] ?? [],
          'categories'=> $_GET['category'] ?? [],
          'priceMin'  => $_GET['priceMin'] ?? null,
          'priceMax'  => $_GET['priceMax'] ?? null,
          'sort'      => $_GET['sort'] ?? null,
          'page' => (int) $_GET['page'] ?? 1,
          'perPage' => (int) $productsPerPage ?? 10
      ]);

      // $products = $this->productService->getFilteredProducts($filterDto);
      $categories = $this->categoryService->getCategoryTree();
      $brands = $this->brandService->getAllBrandsDto();

      // Получаем продукты с учётом пагинации
      $filteredProductsData = $this->productService->getFilteredProducts( filters: $filterDto, perPage: 15);
// dd($filteredProductsData);
      $products =  $filteredProductsData['products'];
      $total = $filteredProductsData['total'];
      $filters = $filteredProductsData['filters'];
      $pagination = $filters['pagination'];
      // $total = $this->productService->countProducts();
      // dd($products);
      $mainCategories = $this->categoryService->getMainCategories();

      // $seo = [];
      // получаем SEO DTO
  
      // foreach($products as $product) {
      //   $seo[$product->getId()] = $this->seoService->getSeoForPage('product', $product);
      // }


      // Это кол-во товаров, показанных на этой странице
   
      $shown = (($pagination['page_number'] - 1) * 9) + count($products);
      $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);
        

      // Формируем единую модель для передачи в шаблон
      $viewModel = [
          'products' => $products,
          'filterDto' => $filterDto,
          'brands' => $brands,
          'categories' => $categories,
          'total' => $total,
          'shown' => $shown,
          'locale' => $this->currentLang
      ];


      // Подключение шаблонов страницы
      $this->renderLayout('shop/catalog', [
            'pagination' => $pagination,
            'pageTitle' => $pageTitle,
            'routeData' => $routeData,
            'breadcrumbs' => $breadcrumbs,
            'viewModel' => $viewModel
      ]);
    }
}


