<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Admin\Brand;

use Vvintage\Routing\RouteData;

use Vvintage\Controllers\Admin\BaseAdminController;
use Vvintage\Models\Brand\Brand;
use Vvintage\DTO\Brand\BrandDTO;
use Vvintage\Services\Admin\Brand\AdminBrandService;
use Vvintage\Services\Admin\Validation\AdminBrandValidator;


class AdminBrandController extends BaseAdminController 
{
  private AdminBrandService $service;
  private AdminBrandValidator $validator;

  public function __construct()
  {
    parent::__construct();
    $this->service = new AdminBrandService();
    $this->validator = new AdminBrandValidator();
  }

  public function all(RouteData $routeData)
  {
    $this->isAdmin();
    $this->setRouteData($routeData);
    $this->renderAll($routeData);
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
    $this->renderNew($routeData);
  }

  public function delete (RouteData $routeData)
  {
    $this->isAdmin();
    $this->setRouteData($routeData);
    $this->renderDelete($routeData);
  }

  private function renderAll(): void
  {
    // Название страницы
    $pageTitle = 'Бренды';

    $brandsPerPage = 9;

    // Устанавливаем пагинацию
    $pagination = pagination($brandsPerPage, 'brands');
    $brands =  $this->service->getBrandsAdminListDTO();
  
    $total = $this->service->getAllBrandsCount();
        
    $this->renderLayout('brands/all',  [
      'pageTitle' => $pageTitle,
      'routeData' => $this->routeData,
      'brands' => $brands,
      'pagination' => $pagination,
      'flash' => $this->flash


    ]);

  }

  private function renderNew(): void
  {
      $this->handleBrandForm();
  }

  private function renderEdit(): void
  {
      $this->handleBrandForm((int) $this->routeData->uriGet);
  }

  private function handleBrandForm(?int $brandId = null): void
  {
      $brand = $brandId ? $this->service->getBrandById($brandId) : null;
      if($brand) {
        $translations = $this->service->getTranslations($brandId);
        $brand->setTranslations($translations);
      }

      if ($brandId && !$brand) {
          $this->flash->pushError('Бренд не найден.');
          return;
      }


      if (isset($_POST['submit'])) $this->processBrandFormSubmission($_POST, $brandId); 

      // Всегда рендерим форму (новая или с ошибками)
      $this->renderLayout('brands/single', [
          'pageTitle' => $brandId ? 'Бренды - редактирование' : 'Бренды - создание',
          'routeData' => $this->routeData,
          'brand' => $brand,
          'languages' => $this->languages,
          'currentLang' => $this->currentLang,
          'flash' => $this->flash
      ]);
  }

  private function processBrandFormSubmission(array $data, ?int $brandId): void
  {
      // Проверка CSRF
      if (!check_csrf($data['csrf'] ?? '')) {
        $this->flash->pushError('Неверный токен безопасности.');
        $this->redirect('admin/brand');
      } 

      // Валидация
      $result = $this->validator->validate($data);

      // Если есть ошибки - пройдём по массиву и покажем.
      if(!empty($result['errors'])) {
        $this->renderErrors($result['errors']);
   
        if($brandId) $this->redirect("admin/brand-edit/{$brandId}"); // редирект
        $this->redirect('admin/brand-new');
      }

      
      // Сохраняем
      $data = $result['data'];
      $id =  $brandId
                ? $this->service->updateBrandDraft($brandId, $data )
                : $this->service->createBrandDraft($data);
  

      if (!$id) {
        $this->flash->pushError('Не удалось сохранить бренд. Попробуйте ещё раз.');
        if($brandId) $this->redirect("admin/brand-edit/{$brandId}"); // редирект
        $this->redirect('admin/brand-new');
      } 

      // Сообщение об успехе
      $message = $brandId ? 'Бренд успешно обновлен.' : 'Бренд успешно создан.';
      $this->flash->pushSuccess($message);

      $this->redirect("admin/brand-edit/{$id}"); // редирект
  }

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



  private function renderDelete(): void
  {
    // Название страницы
    $pageTitle = 'Удалить бренд';

    $id = $this->routeData->uriGet ? (int) $this->routeData->uriGet : null;

    if (!$id) $this->redirect('admin/brand');

    $brand = $this->service->getBrandById($id);

    if (isset($_POST['submit'])) {

      $csrfToken = $_POST['csrf'] ?? '';

      if (!$csrfToken) {
        $this->flash->pushSuccess('Неверный токен безопасности');
        $this->redirect('admin/brand');
      }

      $this->service->deleteBrand($id);

      $this->flash->pushSuccess('Бренд успешно удален.');
      $this->redirect('admin/brand');
    }

    $this->renderLayout('brands/delete',  [
      'pageTitle' => $pageTitle,
      'routeData' => $this->routeData,
      'brand' => $brand,
      'flash' => $this->flash
    ]);

  }

}