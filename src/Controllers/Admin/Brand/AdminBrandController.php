<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Admin\Brand;

use Vvintage\Routing\RouteData;

use Vvintage\Controllers\Admin\BaseAdminController;
use Vvintage\Models\Brand\Brand;
use Vvintage\DTO\Brand\BrandDTO;
use Vvintage\Services\Admin\Brand\AdminBrandService;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Admin\Validation\AdminBrandValidator;
// use Vvintage\Repositories\Brand\BrandRepository;



class AdminBrandController extends BaseAdminController 
{
  private AdminBrandService $service;
  private AdminBrandValidator $validator;
  private FlashMessage $flash;

  public function __construct(FlashMessage $flash)
  {
    parent::__construct();
    $this->service = new AdminBrandService();
    $this->validator = new AdminBrandValidator();
    $this->flash = $flash;
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
      'pagination' => $pagination,
      'flash' => $this->flash


    ]);

  }

  private function handleBrandForm(RouteData $routeData, ?int $brandId = null): void
  {
      $brand = $brandId ? $this->service->getBrandById($brandId) : null;

      if ($brandId && !$brand) {
          $this->flash->pushError('Бренд не найден.');
          // форма не существует — можно сделать редирект или показать пустую страницу
          $this->renderLayout('brands/single', [
              'pageTitle' => 'Бренды - редактирование',
              'routeData' => $routeData,
              'brand' => null,
              'languages' => $this->languages,
              'currentLang' => $this->currentLang,
              'flash' => $this->flash
          ]);
          return;
      }

      if (isset($_POST['submit'])) {
          // Проверка CSRF
          if (!check_csrf($_POST['csrf'] ?? '')) {
              $this->flash->pushError('Неверный токен безопасности.');
          } else {
              // Валидация
              $validate = $brandId ? $this->validator->edit($_POST) : $this->validator->new($_POST);

              if (!$validate) {
                  $this->flash->pushError($brandId 
                      ? 'Не удалось обновить бренд. Проверьте данные.' 
                      : 'Не удалось сохранить новый бренд. Проверьте данные.');
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

                  $brandDTO = new BrandDTO([
                      'title' => $_POST['title'][$mainLang] ?? '',
                      'description' => $_POST['description'][$mainLang] ?? '',
                      'image' => $_POST['image'] ?? '',
                      'translations' => $translations,
                  ]);

                  $brand = Brand::fromDTO($brandDTO);

                  $saved = $brandId
                      ? $this->service->updateBrand($brandId, $_POST)
                      : $this->service->createBrand($brandDTO);

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
      $this->handleBrandForm($routeData, (int)$routeData->uriGetParam);
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