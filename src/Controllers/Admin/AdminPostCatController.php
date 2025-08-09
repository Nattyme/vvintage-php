<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Admin;

use Vvintage\Routing\RouteData;

/** Контроллеры */
use Vvintage\Controllers\Admin\BaseAdminController;

/** Репозитории */
use Vvintage\Repositories\PostCategory\PostCategoryRepository;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Config\LanguageConfig;

/** Сервисы */
// use Vvintage\Services\Admin\AdminStatsService;

class AdminPostCatController extends BaseAdminController 
{
  private const TABLE = 'post_categories';
  private PostCategoryRepository $categoryRepository;
  private FlashMessage $notes;
  

  public function __construct(PostCategoryRepository $categoryRepository, FlashMessage $notes)
  {
    parent::__construct();
    $this->categoryRepository = $categoryRepository;
    $this->notes = $notes;

  }

  public function all(RouteData $routeData)
  {
    $this->isAdmin();
    $this->renderAll($routeData);
  }

  public function edit(RouteData $routeData)
  {
    $this->isAdmin();
    $this->renderEdit($routeData);
  }

  public function new(RouteData $routeData)
  {
    $this->isAdmin();
    $this->renderNew($routeData);
  }

  public function delete (RouteData $routeData)
  {
    $this->isAdmin();
    $this->renderDelete($routeData);
  }

  private function renderAll(RouteData $routeData): void
  {
    // Название страницы
    $pageTitle = 'Категории блога';

    // Получаем данные из GET-запроса
    $searchQuery = $_GET['query'] ?? '';
    $filterSection = $_GET['action'] ?? ''; // имя селекта - action

    $categoryPerPage = 9;

    // Устанавливаем пагинацию
    $pagination = pagination($categoryPerPage, self::TABLE);
    $cats = $this->categoryRepository->getAllCategories($pagination);
    $mainCats = $this->categoryRepository->getMainCats();
    $total = $this->categoryRepository->getAllCategoriesCount();
        
    $this->renderLayout('post-categories/all',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
      'cats' => $cats,
      'mainCats' => $mainCats,
      'searchQuery' => $searchQuery,
      'filterSection' => $filterSection,
      'pagination' => $pagination
    ]);

  }

  private function renderNew(RouteData $routeData): void
  {
    // Название страницы
    $pageTitle = 'Категории блога - новая';

        
    $this->renderLayout('post-categories/new',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
      'currentLang' => $this->currentLang,
    ]);

  }

  private function renderEdit(RouteData $routeData): void
  {
    // Название страницы
    $pageTitle = 'Редактирование категории';

    $pageClass = 'admin-page';

    // Задаем название страницы и класс
    if( isset($_POST['submit'])) {
      // Проверка токена
      if (!check_csrf($_POST['csrf'] ?? '')) {
        $_SESSION['errors'][] = ['error', 'Неверный токен безопасности'];
      }

      // Проверка на заполненность названия
      if( trim($_POST['title']) == '' ) {
        $_SESSION['errors'][] = ['title' => 'Введите название бренда'];
      } 

      // Если нет ошибок
      if ( empty($_SESSION['errors'])) {
        $categories = $this->categoryRepository->getBrandById((int) $routeData->uriGetParam);
        // $brand->title = $_POST['title'];

        // R::store($brand);

        $_SESSION['success'][] = ['title' => 'Бренд успешно обновлен.'];
      }
    }


    // Запрос постов в БД с сортировкой id по убыванию
    $categories = $this->categoryRepository->getPostCatById( (int) $routeData->uriGetParam);


        
    $this->renderLayout('post-categories/edit',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
      'categories' => $categories,
      'languages' => $this->languages,
      'currentLang' => $currentLang
    ]);

  }

  private function renderDelete(RouteData $routeData): void
  {
    // Название страницы
    $pageTitle = 'Удалить категорию';

    $categoriesPerPage = 9;

    // Устанавливаем пагинацию
    $pagination = pagination($categoriesPerPage, self::TABLE);
    $categories = $this->categoryRepository->getAllCategories($pagination);
    $total = $this->categoryRepository->getAllBrandsCount();
        
    $this->renderLayout('post-categories/delete',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
      'categories' => $categories,
      'pagination' => $pagination
    ]);

  }

}