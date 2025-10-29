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
    // $brands =  $this->service->getAllBrandsDto();
    $total = $this->service->getAllBrandsCount();
        
    $this->renderLayout('brands/all',  [
      'pageTitle' => $pageTitle,
      'routeData' => $this->routeData,
      'brands' => $brands,
      'pagination' => $pagination,
      'flash' => $this->flash


    ]);

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
          // форма не существует редирект или показать пустую страницу
          // $this->renderLayout('brands/single', [
          //     'pageTitle' => 'Бренды - редактирование',
          //     'routeData' => $routeData,
          //     'brand' => null,
          //     'languages' => $this->languages,
          //     'currentLang' => $this->currentLang,
          //     'flash' => $this->flash
          // ]);
          return;
      }


      if (isset($_POST['submit'])) {
          // Проверка CSRF
          if (!check_csrf($_POST['csrf'] ?? '')) {
              $this->flash->pushError('Неверный токен безопасности.');
          } else {
              // Валидация
              $validate = $this->validator->validate($_POST);
              $textData = $validate['data'];
              $errors = $validate['errors'];
              // $validate = $brandId ? $this->validator->edit($_POST) : $this->validator->new($_POST);

              if (!$errors) {
                  $this->flash->pushError($brandId 
                      ? 'Не удалось обновить бренд. Проверьте данные.' 
                      : 'Не удалось сохранить новый бренд. Проверьте данные.');
              } else {
                  $translations = $textData['translations'];
                  $saved = $brandId
                      ? $this->service->updateBrand($brandId, $translations)
                      : $this->service->createBrandDraft($translations);

                  if ($saved) {
                      $this->flash->pushSuccess($brandId ? 'Бренд успешно обновлен.' : 'Бренд успешно создан.');
                      header('Location: ' . HOST . 'admin/brand');
                      exit; // здесь return нужен, чтобы не рендерить форму
                  } else {
                      $this->flash->pushError('Не удалось сохранить бренд. Попробуйте ещё раз.');
                  }
              }
          }
      }

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


  private function renderNew(): void
  {
      $this->handleBrandForm();
  }

  private function renderEdit(): void
  {
      $this->handleBrandForm((int) $this->routeData->uriGet);
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