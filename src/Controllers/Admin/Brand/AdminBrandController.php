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
    $pageTitle = 'Бренды';

    $brandsPerPage = 9;

    // Устанавливаем пагинацию
    $pagination = pagination($brandsPerPage, 'brands');
    $brands =  $this->service->getAllBrandsDto();
    $total = $this->service->getAllBrandsCount();
        
    $this->renderLayout('brands/all',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
      'brands' => $brands,
      'pagination' => $pagination,
      'flash' => $this->flash


    ]);

  }

  private function handleBrandForm(RouteData $routeData, ?int $brandId = null): void
  {
      $brand = $brandId ? $this->service->getBrandById($brandId) : null;

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
              // $validate = $brandId ? $this->validator->edit($_POST) : $this->validator->new($_POST);

              if (!$validate) {
                  $this->flash->pushError($brandId 
                      ? 'Не удалось обновить бренд. Проверьте данные.' 
                      : 'Не удалось сохранить новый бренд. Проверьте данные.');
              } else {
                  $translations = $_POST['translations'];
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
          'routeData' => $routeData,
          'brand' => $brand,
          'languages' => $this->languages,
          'currentLang' => $this->currentLang,
          'flash' => $this->flash
      ]);
  }


  private function renderNew(RouteData $routeData): void
  {
      $this->handleBrandForm($routeData);
  }

  private function renderEdit(RouteData $routeData): void
  {
      $this->handleBrandForm($routeData, (int)$routeData->uriGet);
  }


  private function renderDelete(RouteData $routeData): void
  {
    // Название страницы
    $pageTitle = 'Бренды';

    $brandsPerPage = 9;

    // Устанавливаем пагинацию
    $pagination = pagination($brandsPerPage, 'brands');
    $brands = $this->service->getAllBrands($pagination);
    $total = $this->service->getAllBrandsCount();
        
    $this->renderLayout('brands/all',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
      'brands' => $brands,
      'pagination' => $pagination,
      'flash' => $this->flash
    ]);

  }

}