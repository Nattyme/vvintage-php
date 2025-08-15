<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Admin\Brand;

use Vvintage\Routing\RouteData;

use Vvintage\Controllers\Admin\BaseAdminController;
use Vvintage\Services\Admin\Brand\AdminBrandService;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Admin\Validation\AdminBrandValidator;
// use Vvintage\Repositories\Brand\BrandRepository;



class AdminBrandController extends BaseAdminController 
{
  private AdminBrandService $service;
  private AdminBrandValidator $validator;
  private FlashMessage $notes;

  public function __construct(FlashMessage $notes)
  {
    parent::__construct();
    $this->service = new AdminBrandService();
    $this->validator = new AdminBrandValidator();
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
      'pagination' => $pagination
    ]);

  }

  private function handleBrandForm(RouteData $routeData, ?int $brandId = null): void
  {
      $brand = $brandId ? $this->service->getBrandById($brandId) : null;

      if ($brandId && !$brand) {
          $this->notes->pushError('Бренд не найден.');
          // header('Location: /admin/brands');
          // exit;
      }

      if (isset($_POST['submit'])) {
          // Проверка CSRF
          if (!check_csrf($_POST['csrf'] ?? '')) {
              $this->notes->pushError('Неверный токен безопасности.');
              // header('Location: ' . $_SERVER['REQUEST_URI']);
              // exit;
          }

          // Валидация
          $validate = $brandId ? $this->validator->edit($_POST) : $this->validator->new($_POST);

          if (!$validate) {
              $this->notes->pushError($brandId ? 'Не удалось обновить бренд. Проверьте данные.' : 'Не удалось сохранить новый бренд. Проверьте данные.');
              header('Location: ' . $_SERVER['REQUEST_URI']);
              exit;
          }

          // Сохранение
          $saved = $brandId
              ? $this->service->updateBrand($brandId, $_POST)
              : $this->service->createBrand($_POST);

          if ($saved) {
              $this->notes->pushSuccess($brandId ? 'Бренд успешно обновлен.' : 'Бренд успешно создан.');
              header('Location: /admin/brands');
              exit;
          } else {
              $this->notes->pushError('Не удалось сохранить бренд. Попробуйте ещё раз.');
              header('Location: ' . $_SERVER['REQUEST_URI']);
              exit;
          }
      }

      // Передаем бренд в шаблон (может быть null для нового)
      $this->renderLayout('brands/single', [
          'pageTitle' => $brandId ? 'Бренды - редактирование' : 'Бренды - создание',
          'routeData' => $routeData,
          'brand' => $brand,
          'languages' => $this->languages,
          'currentLang' => $this->currentLang
      ]);
  }

  private function renderNew(RouteData $routeData): void
  {
      $this->handleBrandForm($routeData);
  }

  private function renderEdit(RouteData $routeData): void
  {
      $this->handleBrandForm($routeData, (int)$routeData->uriGetParam);
  }




  private function renderDelete(RouteData $routeData): void
  {
    // Название страницы
    $pageTitle = 'Бренды';

    $brandsPerPage = 9;

    // Устанавливаем пагинацию
    $pagination = pagination($brandsPerPage, 'brands');
    $brands = $this->brandRepository->getAllBrands($pagination);
    $total = $this->brandRepository->getAllBrandsCount();
        
    $this->renderLayout('brands/all',  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
      'brands' => $brands,
      'pagination' => $pagination
    ]);

  }

}