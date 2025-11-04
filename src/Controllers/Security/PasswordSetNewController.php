<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Security;

/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;

use Vvintage\Services\SEO\SeoService;
use Vvintage\Services\Page\PageService;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Session\SessionService;
use Vvintage\Services\Security\PasswordSetNewService;
use Vvintage\Services\Validation\PasswordSetNewValidator;

final class PasswordSetNewController extends BaseController 
{
  private SeoService $seoService;
  private PageService $pageService;
  private PasswordSetNewService $setNewPassService;

  public function __construct(
    FlashMessage $flash,
    SessionService $sessionService,
    SeoService $seoService, 
    PasswordSetNewService $setNewPassService
  )
  {
    parent::__construct($flash, $sessionService); // Важно!
    $this->seoService = $seoService;
    $this->pageService = new PageService();
    $this->setNewPassService = $setNewPassService;
  }

  
  public function index($routeData)
  {
      $this->setRouteData($routeData);

      $email = '';
      $resetCode = '';
      $password = '';

      // Обработка отправки формы (POST)
      if (!empty($_POST['set-new-password'])) {
          $email = $_POST['email'] ?? '';
          $resetCode = $_POST['resetCode'] ?? '';
          $password = $_POST['password'] ?? '';

          try {
            $userModel = $this->setNewPassService->handleNewPassSetting( $email, $resetCode, $password);
            $this->flash->pushSuccess('Пароль был успешно изменён');
            $this->redirect('login');
          }
          catch (\Exception $error) {
            $this->flash->pushError($error->getMessage());
            $this->redirect('lost-password');
          }
  
      }

      // Переход по ссылке из письма (GET)
      else if (!empty($_GET['email']) && !empty($_GET['code'])) {
          try {
            $userModel = $this->setNewPassService->handleRecoveryLinkPassing($_GET['email'], $_GET['code']);
          }
          catch (\Exception $error) {
            $this->flash->pushError($error->getMessage());
            $this->redirect('lost-password');
          }
         
      }

      // Иначе — редирект на форму восстановления
      else {
          $this->redirect('lost-password');
      }

      // Отображение формы
      $this->renderForm($routeData ?? [], $newPasswordReady, $email, $resetCode);
  }


  private  function renderForm($routeData, bool $newPasswordReady = false)
  {
    // Название страницы
    $page = $this->pageService->getPageBySlug($routeData->uriModule);
    $pageModel = $this->pageService->getPageModelBySlug( $routeData->uriModule );

    // Если найдена модель страницы - получаем сео
    if($pageModel) $seo = $this->seoService->getSeoForPage('profile-edit', $pageModel);
    
    $pageTitle = "Установить новый пароль";
    $currentLang =  $this->pageService->currentLang;
    $languages = $this->pageService->languages;

    $this->renderAuthLayout('set-new-password', [
      'page' => $page,
      'seo' => $seo,
      'pageTitle' => $pageTitle,
      'currentLang' => $currentLang,
      'languages' => $languages
    ]);
  }

}

