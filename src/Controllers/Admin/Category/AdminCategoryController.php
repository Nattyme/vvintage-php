<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Admin\Category;

use Vvintage\Routing\RouteData;
use Vvintage\Controllers\Admin\BaseAdminController;
use Vvintage\Services\Admin\Category\AdminCategoryService;
use Vvintage\Services\Admin\Validation\AdminCategoryValidator;
use Vvintage\DTO\Admin\Category\CategoryInputDTO;
use Vvintage\Models\Category\Category;


final class AdminCategoryController extends BaseAdminController 
{
  private AdminCategoryValidator $validator;
  private AdminCategoryService $service;

  public function __construct()
  {
    parent::__construct();
    $this->service = new AdminCategoryService();
    $this->validator = new AdminCategoryValidator();
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
    $pageTitle = 'Категории';
    $categoryPerPage = 9;

    // Получаем данные из GET-запроса
    $searchQuery = $_GET['query'] ?? '';
    $filterSection = $_GET['action'] ?? ''; // имя селекта - action



    // Устанавливаем пагинацию
    $pagination = pagination($categoryPerPage, 'categories');
    $cats = $this->service->getAllCategories($pagination);
    $mainCats = $this->service->getMainCategories();
    $total = $this->service->getAllCategoriesCount();
        
    $this->renderLayout('categories/all',  [
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
    $viewPath = 'categories/new';
    $pageTitle = 'Категория - создание';

    $uriGet = $this->routeData->uriGet ?? null;
    $parentId = $this->routeData->uriGet ?? null;
    $mainCats = $this->service->getMainCategories();
    $parentCategory = null;
    
    if($parentId) {    
      $parentId = (int) $parentId;
      $parentCategory = $this->service->getCategoryById($parentId);
    }

    
    if ($parentId && !$parentCategory) {
        $this->flash->pushError('Раздел для добавления категории не найден. Выберите другой');
        $this->redirect('admin/category');
    }

    if(isset($_POST['submit'])) {
     
      if (!check_csrf($_POST['csrf'] ?? '')) {
              $this->flash->pushError('Неверный токен безопасности.');
          } else {
              // Валидация
              $validate = $this->validator->validate($_POST);
              $textData = $validate['data'];
              $errors = $validate['errors'];
    

            if (!empty( $errors)) {
              $this->flash->pushError('Не удалось сохранить новую категорию. Проверьте данные.');
            } else {
              // $category = Category::fromInputDTO($dto);
              // dd(  $category );
              $saved = $this->service->createCategoryDraft( $textData);

              if ($saved) {
                  $this->flash->pushSuccess('Категория успешно создана.');
                  $this->redirect('admin/category');
              } else {
                  $this->flash->pushError('Не удалось сохранить категорию. Попробуйте ещё раз.');
                  $this->redirect('admin/category');
              }
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
    $viewPath = 'categories/edit';
    $pageTitle = 'Категория - редактирование';

    $id = (int) $this->routeData->uriGet ?? null;
    $pageClass = 'admin-page';

    if (!$id) {
      $this->flash->pushError('Не удалось получить категорию для редактирования. Проверьте данные.');
      $this->redirect('admin/category');
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
          $this->redirect('admin/category');
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

        $dto = new CategoryInputDTO([
            'id' => $id,
            'parent_id' => $_POST['parent_id'] ?? 0,
            'slug' => $_POST['slug'] ?? '',
            'title' => $_POST['title'][$mainLang] ?? '',
            'description' => $_POST['description'][$mainLang] ?? '',
            'image' => $_POST['image'] ?? '',
            'translations' => $translations,
        ]);

        $category = Category::fromDTO($dto);

        $saved = $this->service->updateCategory( $category);

        if ($saved) {
          $this->flash->pushSuccess('Категория успешно создана.');
           $this->redirect('admin/category-edit', $this->routeData->uriGet);
        } else {
            $this->flash->pushError('Не удалось сохранить категорию. Попробуйте ещё раз.');
            $this->redirect('admin/category');
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
    $pageTitle = 'Удалить категорию';

    $id = $this->routeData->uriGet ? (int) $this->routeData->uriGet : null;

    if (!$id) $this->redirect('admin/category');

    $category = $this->service->getCategoryById($id);


    // Если нет ошибок
    if (isset($_POST['submit'])) {
      $csrfToken = $_POST['csrf'] ?? '';

      if (!$csrfToken) {
        $this->flash->pushSuccess('Неверный токен безопасности');
        $this->redirect('admin/category');
      }

      $this->service->deleteCategory($id);

      $this->flash->pushSuccess('Категория успешно удалена.');
      $this->redirect('admin/category');
    }

    $this->renderLayout('categories/delete',  [
      'pageTitle' => $pageTitle,
      'routeData' => $this->routeData,
      'category' => $category,
      'flash' => $this->flash
    ]);

  }


}