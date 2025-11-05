<?php
declare(strict_types=1);

namespace Vvintage\Admin\Controllers\Category;

use Vvintage\Routing\RouteData;
use Vvintage\Admin\Controllers\BaseAdminController;

use Vvintage\Models\Category\Category;

use Vvintage\Admin\Services\Category\AdminCategoryService;
use Vvintage\Admin\Services\Validation\AdminCategoryValidator;
use Vvintage\Utils\Services\FlashMessage\FlashMessage;
use Vvintage\Utils\Services\Session\SessionService;


final class AdminCategoryController extends BaseAdminController 
{
  private AdminCategoryValidator $validator;
  private AdminCategoryService $service;

  public function __construct(
    FlashMessage $flash,
    SessionService $sessionService
  )
  {
    parent::__construct($flash, $sessionService);
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
    $pageTitle = 'Категории товаров';
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
    
    // Если это главная категория 
    if($parentId) {    
      $parentId = (int) $parentId;
      $parentCategory = $this->service->getCategoryById($parentId);
    }

    
    if ($parentId && !$parentCategory) {
        $this->flash->pushError('Раздел для добавления категории не найден. Выберите другой');
        $this->redirect('admin/category');
    }

    // Если отправлена форма
    if (isset($_POST['submit'])) {
     
      if (!check_csrf($_POST['csrf'] ?? '')) {
        $this->flash->pushError('Неверный токен безопасности.');
        $this->redirect('admin/category-new');
      } 

      $result = $this->validator->validate($_POST);

      // Если есть ошибки - пройдём по массиву и покажем.
      if(!empty($result['errors'])) {
        $this->renderErrors($result['errors']);
        $this->redirect('admin/category-new');
      }
      
      // Сохраняем
      $saved = $this->service->createCategoryDraft( $result['data']);

      if ($saved) {
          $this->flash->pushSuccess('Категория успешно создана.');
          $this->redirect('admin/category');
      } else {
          $this->flash->pushError('Не удалось сохранить новую категорию. Проверьте данные и попробуйте ещё раз.');
          $this->redirect('admin/category');
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

    // Если отправлена форма
    if(isset($_POST['submit'])) {
     
      if (!check_csrf($_POST['csrf'] ?? '')) {
        $this->flash->pushError('Неверный токен безопасности.');
        $this->redirect("admin/category-edit/{$id}");
      } 

      $result = $this->validator->validate($_POST);

      // Если есть ошибки - пройдём по массиву и покажем.
      if(!empty($result['errors'])) {
        $this->renderErrors($result['errors']);
        $this->redirect("admin/category-edit/{$id}");
      }

      // Сохраняем
      $saved = $this->service->updateCategoryDraft( $id, $result['data']);

      if ($saved) {
          $this->flash->pushSuccess('Категория успешно обновлена.');
          // dd( $this->flash);
          $this->redirect("admin/category-edit/{$id}");
      } 

      $this->flash->pushError('Не удалось обновить категорию. Проверьте данные и попробуйте ещё раз.');
      $this->redirect("admin/category-edit/{$id}");
  
    }


    // Получаем DTO категории для отображения
    $category = $this->service->createCategoryEditDTO($id);
  // dd($this->flash);
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

    if (!$id) $this->redirect('admin/category'); // если не нашли

    // Получаем DTO категории для отображения
    $category = $this->service->createCategoryEditDTO($id);

    // Если отправлена форма
    if (isset($_POST['submit'])) {
      $csrfToken = $_POST['csrf'] ?? '';

      if (!$csrfToken) {
        $this->flash->pushError('Неверный токен безопасности');
        $this->redirect('admin/category');
      }

      // Удаляем категорию
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

  /**
   * Outputs error messages for the given fields and languages
   * @param array $errors - associative array with fields as keys and
   *   associative arrays with language codes as keys and error messages as values
   */
  private function renderErrors(array $errors): void
  {
      foreach ($errors as $fields) {
        foreach ($fields as $lang => $messages) {
            array_walk_recursive($messages, function($message) use ($lang){
              $this->flash->pushError("Ошибка в поле языка {$lang}: ", $message );
            });
        }
      }
  
      return;
  }


}