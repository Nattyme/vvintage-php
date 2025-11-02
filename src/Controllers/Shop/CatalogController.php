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
use Vvintage\Services\SEO\SeoService;
use Vvintage\Services\Page\Breadcrumbs;
use Vvintage\Services\Page\PageService;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Session\SessionService;

use Vvintage\DTO\Product\Filter\ProductFilterDTO;


require_once ROOT . "./libs/functions.php";



final class CatalogController extends BaseController
{
    private ProductService $productService;
    private CategoryService $categoryService;
    private BrandService $brandService;
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
      $this->categoryService = new CategoryService();
      $this->brandService = new BrandService();
      $this->seoService = $seoService;
      $this->breadcrumbsService = $breadcrumbs;
      $this->pageService = new PageService();
    }


    public function index(RouteData $routeData): void
    {
      // Название страницы
      $productsPerPage = 12;
      $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;


      $filterDto = new ProductFilterDTO([
          'brands'    => $_GET['brand'] ?? [],
          'categories'=> $_GET['category'] ?? [],
          'priceMin'  => $_GET['priceMin'] ?? null,
          'priceMax'  => $_GET['priceMax'] ?? null,
          'sort'      => $_GET['sort'] ?? null,
          'page' =>  $page,
          'perPage' => (int) $productsPerPage ?? 10,
          'status' => 'active'
      ]);


      // Получаем категории и бренды
      $categories = $this->categoryService->getCategoryTreeDTO();
      $brands = $this->brandService->getAllBrandsDto();

      // Получаем продукты с учётом пагинации
      $filteredProductsData = $this->productService->getProductsForCatalog( filters: $filterDto, perPage: 15);
  
      $mainCategories = $this->categoryService->getMainCategories();

      $page = $this->pageService->getPageBySlug($routeData->uriModule);
      $pageModel = $this->pageService->getPageModelBySlug($routeData->uriModule);

      // получаем общие данные страницы 
      $this->setRouteData($routeData); // <-- передаём routeData
      $pageTitle = $page['title'];

      $filters = $filteredProductsData['filters'];
      $pagination = $filters->pagination;
      
      // Это кол-во товаров, показанных на этой странице
      $shown = (($pagination['page_number'] - 1) * 9) + count($filteredProductsData['products']);
      $breadcrumbs = $this->breadcrumbsService->generate($routeData, $pageTitle);

      $seo = $this->seoService->getSeoForPage('catalog', $pageModel);

      // Формируем единую модель для передачи в шаблон
      $viewModel = [
          'products' => $filteredProductsData['products'],
          'filterDto' => $filterDto,
          'brands' => $brands,
          'categories' => $categories,
          'total' => $filteredProductsData['total'],
          'shown' => $shown
      ];


      // Подключение шаблонов страницы
      $this->renderLayout('shop/catalog', [
            'seo' => $seo,
            'pagination' => $pagination,
            'pageTitle' => $pageTitle,
            'navigation' => $this->pageService->getLocalePagesNavTitles(),
            'routeData' => $routeData,
            'breadcrumbs' => $breadcrumbs,
            'viewModel' => $viewModel,
            'currentLang' =>  $this->pageService->currentLang,
            'languages' => $this->pageService->languages
      ]);
    }
}


