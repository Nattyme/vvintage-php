<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Admin\PostCategory;

use Vvintage\Routing\RouteData;
use Vvintage\Controllers\Admin\BaseAdminController;
use Vvintage\Services\Admin\PostCategory\AdminPostCategoryService;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Admin\Validation\AdminPostCategoryValidator;
use Vvintage\DTO\PostCategory\PostCategoryInputDTO;
use Vvintage\Models\PostCategory\PostCategory;


final class AdminPostCategoryController extends BaseAdminController 
{
  private AdminPostCategoryValidator $validator;
  private AdminPostCategoryService $service;
  private FlashMessage $flash;

  private const TABLE = 'postcategories';

  public function __construct()
  {
    parent::__construct();
    $this->service = new AdminPostCategoryService();
    $this->flash = new FlashMessage();
    $this->validator = new AdminPostCategoryValidator();
  }

  public function all(RouteData $routeData)
  {
    $this->isAdmin();
    $this->setRouteData($routeData);
    $this->renderAll();
  }

  public function edit(RouteData $routeData)
  {
    $this->isAdmin();
    $this->setRouteData($routeData);
    $this->renderEdit($routeData);
  }

  public function new(RouteData $routeData)
  {
    $this->isAdmin();
    $this->setRouteData($routeData);
    $this->renderNew();
  }

  public function delete (RouteData $routeData)
  {
    $this->isAdmin();
    $this->setRouteData($routeData);
    $this->renderDelete();
  }

  private function renderAll(): void
  {
    // Название страницы
    $pageTitle = 'Категории блога';

    // Получаем данные из GET-запроса
    $searchQuery = $_GET['query'] ?? '';
    $filterSection = $_GET['action'] ?? ''; // имя селекта - action

    $categoryPerPage = 9;

    // Устанавливаем пагинацию
    $pagination = pagination($categoryPerPage, self::TABLE);
    $cats = $this->service->getAllCategories($pagination);
    $mainCats = $this->service->getMainCategories();
    $total = $this->service->getAllCategoriesCount();
        
    $this->renderLayout('post-categories/all',  [
      'pageTitle' => $pageTitle,
      'routeData' => $this->routeData,
      'cats' => $cats,
      'mainCats' => $mainCats,
      'searchQuery' => $searchQuery,
      'filterSection' => $filterSection,
      'pagination' => $pagination,
      'flash' => $this->flash
    ]);

  }

  private function renderNew(): void
  {
    $viewPath = 'post-categories/new';
    $pageTitle = 'Категория - создание';

    $uriGet = $this->routeData->uriGet ?? null;
    $parentId = $this->routeData->uriGet ?? null;
    $mainCats = $this->service->getMainCategories();
    
    if( $parentId) {    
      $parentId = (int) $parentId;
      $parentCategory = $this->service->getCategoryById($parentId);
    }

    
    if ($parentId && !$parentCategory) {
        $this->flash->pushError('Раздел для добавления категории блога не найден. Выберите другой');
        $this->redirect('admin/post-category');
    }

    if(isset($_POST['submit'])) {
   
      // $validate = $this->validator->new($_POST);
      $validate = true;

      if (!$validate) {
        $this->flash->pushError('Не удалось сохранить новую категорию блога. Проверьте данные.');
      } else {
              $translations = [];
              foreach ($_POST['title'] as $lang => $title) {
                  $translations[$lang] = [
                      'title' => $_POST['title'][$lang] ?? '',
                      'description' => $_POST['description'][$lang] ?? '',
                      'meta_title' => $_POST['meta_title'][$lang] ?? '',
                      'meta_description' => $_POST['meta_description'][$lang] ?? '',
                  ];
              }

              $mainLang = 'ru';

              $dto = new PostCategoryInputDTO([
                  'parent_id' => $_POST['parent_id'] ?? 0,
                  'slug' => $_POST['slug'] ?? '',
                  'title' => $_POST['title'][$mainLang] ?? '',
                  'description' => $_POST['description'][$mainLang] ?? '',
                  'image' => $_POST['image'] ?? '',
                  'translations' => $translations,
              ]);

              $category = PostCategory::fromDTO($dto);

              $saved = $this->service->createCategory( $category);

              if ($saved) {
                  $this->flash->pushSuccess('Новая категория блога успешно создана.');
                  $this->redirect('admin/category');
              } else {
                  $this->flash->pushError('Не удалось сохранить категорию блога. Попробуйте ещё раз.');
                  $this->redirect('admin/post-category');
              }
      }
      
    }

    $this->renderLayout($viewPath,  [
      'pageTitle' => $pageTitle,
      'routeData' => $this->routeData,
      'flash' => $this->flash,
      'uriGet' => $uriGet,
      'parentCategory' => $parentCategory
      
    ]);
  }

  private function renderEdit(): void
  {
    $viewPath = 'post-categories/edit';
    $pageTitle = 'Категория блога - редактирование';

    $id = (int) $this->routeData->uriGet ?? null;
    $pageClass = 'admin-page';

    if (!$id) {
      $this->flash->pushError('Не удалось получить категорию для редактирования. Проверьте данные.');
      $this->redirect('admin/post-category');
    } 

    $category = $this->service->getCategoryById($id);

    if( $category->getParentId()) {    
      $parendId = $category->getParentId();
      $parentCategory = $this->service->getCategoryById($parendId);
    }

    // $validate = $this->validator->new($_POST);
    if(isset($_POST['submit'])) {
        $validate = true;

      
        if (!$validate) {
          $this->flash->pushError('Не удалось получить категорию для редактирования. Проверьте данные.');
          $this->redirect('admin/post-category');
        } 

        $translations = [];
    
        foreach ($_POST['title'] as $lang => $title) {
            $translations[$lang] = [
                'title' => $_POST['title'][$lang] ?? '',
                'description' => $_POST['description'][$lang] ?? '',
                'meta_title' => $_POST['meta_title'][$lang] ?? '',
                'meta_description' => $_POST['meta_description'][$lang] ?? '',
            ];
        }

        $mainLang = 'ru';

        $dto = new PostCategoryInputDTO([
            'id' => $id,
            'parent_id' => $_POST['parent_id'] ?? 0,
            'slug' => $_POST['slug'] ?? '',
            'title' => $_POST['title'][$mainLang] ?? '',
            'description' => $_POST['description'][$mainLang] ?? '',
            'image' => $_POST['image'] ?? '',
            'translations' => $translations,
        ]);

        $category = PostCategory::fromDTO($dto);

        $saved = $this->service->updatePostCategory( $category);

        if ($saved) {
          $this->flash->pushSuccess('Категория блога успешно создана.');
           $this->redirect('admin/post-category-edit', $this->routeData->uriGet);
        } else {
            $this->flash->pushError('Не удалось сохранить категорию. Попробуйте ещё раз.');
            $this->redirect('admin/post-category');
        }
        


    }
    
    $this->renderLayout($viewPath,  [
      'pageTitle' => $pageTitle,
      'routeData' => $this->routeData,
      'category' => $category,
      'languages' => $this->languages,
      'currentLang' => $this->currentLang,
      'flash' => $this->flash,
      'parentCategory' => $parentCategory ?? null
    ]);

  }

  private function renderDelete(): void
  {
    // Название страницы
    $pageTitle = 'Удалить категорию блога';

    $brandsPerPage = 9;

    // Устанавливаем пагинацию
    $pagination = pagination($brandsPerPage, 'post-categories');
    $category = $this->service->getAllCategories($pagination);
    $category = $this->service->getAllCategoriesCount();
        
    $this->renderLayout('post-categories/all',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
      'categories' => $categories,
      'pagination' => $pagination,
      'flash' => $this->flash
    ]);

  }

}