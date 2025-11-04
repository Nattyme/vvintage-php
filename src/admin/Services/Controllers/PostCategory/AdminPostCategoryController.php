<?php
declare(strict_types=1);

namespace Vvintage\Admin\Controllers\PostCategory;

use Vvintage\Routing\RouteData;

use Vvintage\Admin\Controllers\BaseAdminController;

use Vvintage\Services\Admin\PostCategory\AdminPostCategoryService;
use Vvintage\Services\Admin\Validation\AdminPostCategoryValidator;
use Vvintage\DTO\PostCategory\PostCategoryInputDTO;
use Vvintage\Models\PostCategory\PostCategory;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Session\SessionService;


final class AdminPostCategoryController extends BaseAdminController 
{
  private AdminPostCategoryValidator $validator;
  private AdminPostCategoryService $service;

  private const TABLE = 'postcategories';

  public function __construct(
     FlashMessage $flash,
    SessionService $sessionService,
  )
  {
    parent::__construct($flash, $sessionService);
    $this->service = new AdminPostCategoryService();
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
    $categoryPerPage = 9;

    // Получаем данные из GET-запроса
    $searchQuery = $_GET['query'] ?? '';
    $filterSection = $_GET['action'] ?? ''; // имя селекта - action

   

    // Устанавливаем пагинацию
    $pagination = pagination($categoryPerPage, 'postcategories');
    $categoriesDtos = $this->service->getAllCategoriesAdminList();

    $this->renderLayout('post-categories/all',  [
      'pageTitle' => $pageTitle,
      'routeData' => $this->routeData,
      'categories' => $categoriesDtos,
      // 'mainCats' => $mainCats,
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

    $parentCategory = $parentId ? $this->service->getCategoryById( (int) $parentId) : 0;
          
    if ( $uriGet && !$parentId && !$parentCategory) {

        $this->flash->pushError('Раздел для добавления категории блога не найден. Выберите другой');
        $this->redirect('admin/category-blog');
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
                  'parent_id' => $_POST['parent_id'] ?? null,
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
                  $this->redirect('admin/category-blog');
              } else {
                  $this->flash->pushError('Не удалось сохранить категорию блога. Попробуйте ещё раз.');
                  $this->redirect('admin/category-blog');
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
      $this->redirect('admin/category-blog');
    } 

    $category = $this->service->getCategoryEditAdmin($id);

    // $validate = $this->validator->new($_POST);
    if(isset($_POST['submit'])) {
        $validate = true;

      
        if (!$validate) {
          $this->flash->pushError('Не удалось получить категорию для редактирования. Проверьте данные.');
          $this->redirect('admin/category-blog');
        } 

        $translations = [];
 
        foreach ($_POST['translations'] as $lang => $data) {
           
            $translations[$lang] = [
                'title' => $data['title'] ?? '',
                'description' => $data['description']?? '',
                'meta_title' => $data['meta_title'] ?? '',
                'meta_description' => $data['meta_description'] ?? '',
            ];
        }

        $mainLang = 'ru';

        $dto = new PostCategoryInputDTO([
            'id' => $id,
            'parent_id' => $_POST['parent_id'] ?? null,
            'slug' => $_POST['slug'] ?? '',
            'title' => $_POST['title'][$mainLang] ?? '',
            'description' => $_POST['description'][$mainLang] ?? '',
            'image' => $_POST['image'] ?? '',
            'translations' => $translations,
        ]);

        // Сохранение категории в БД
        $saved = $this->service->updateCategory( $dto);

        if ($saved) {
          $this->flash->pushSuccess('Категория блога успешно обновлена.');
          $this->redirect('admin/category-blog-edit', $this->routeData->uriGet);
        } else {
            $this->flash->pushError('Не удалось сохранить категорию. Попробуйте ещё раз.');
            $this->redirect('admin/category-blog');
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

    $id = $this->routeData->uriGet ? (int) $this->routeData->uriGet : null;

    if (!$id) $this->redirect('admin/category-blog');

    $category = $this->service->getCategoryById($id);


    // Если нет ошибок
    if (isset($_POST['submit'])) {
      $csrfToken = $_POST['csrf'] ?? '';

      if (!$csrfToken) {
        $this->flash->pushSuccess('Неверный токен безопасности');
        $this->redirect('admin/category-blog');
      }

      $this->service->deleteCategory($id);

      $this->flash->pushSuccess('Категория успешно удалена.');
      $this->redirect('admin/category-blog');
    }


        
    $this->renderLayout('post-categories/delete',  [
      'pageTitle' => $pageTitle,
      'routeData' => $this->routeData,
      'category' => $category,
      'flash' => $this->flash
    ]);

  }

}