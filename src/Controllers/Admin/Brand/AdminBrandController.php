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

  private function renderNew(RouteData $routeData): void
  {
    // Название страницы
    $pageTitle = 'Бренды - создание';
    $viewPath = 'brands/single';

   
    if( isset($_POST['submit']) ) {
      $validate = $this->validator->new($_POST);

      if(!$validate) {
        $this->notes->pushError('Не удалось сохранить новый бренд. Попробуйте ещё раз');
      }
    }

   

   
    $this->renderLayout($viewPath,  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData
    ]);

  }

  private function renderEdit(RouteData $routeData): void
  {
    // Название страницы
    $pageTitle = 'Бренды - редактирование';

    $viewPath = 'brands/single';

    $pageClass = 'admin-page';

    // Задаем название страницы и класс
    if( isset($_POST['submit'])) {
      // Проверка токена
      if (!check_csrf($_POST['csrf'] ?? '')) {
        $_SESSION['errors'][] = ['error', 'Неверный токен безопасности'];
      }

      // Проверка на заполненность названия
      foreach ($_POST['title'] as $key=>$value) {
        if( trim($value) == '' ) {
          $_SESSION['errors'][] = ['title' => 'Введите название бренда'];
        } 
      }
      

      // Если нет ошибок
      // if ( empty($_SESSION['errors'])) {
        // $brand = $this->brandRepository->getBrandById((int) $routeData->uriGetParam);
        // $brand->title = $_POST['title'];

        // R::store($brand);

      //   $_SESSION['success'][] = ['title' => 'Бренд успешно обновлен.'];
      // }
    }

    // Запрос бренда
    $brand = $this->service->getBrandById( (int) $routeData->uriGetParam);
        
    $this->renderLayout($viewPath,  [
      'pageTitle' => $pageTitle,
      'routeData' => $routeData,
      'brand' => $brand,
      'languages' => $this->languages,
      'currentLang' => $this->currentLang
    ]);

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