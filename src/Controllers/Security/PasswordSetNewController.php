<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Security;

/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;

use Vvintage\Services\SEO\SeoService;
use Vvintage\Services\Page\PageService;
use Vvintage\Services\Security\PasswordSetNewService;
use Vvintage\Services\Validation\PasswordSetNewValidator;

final class PasswordSetNewController extends BaseController 
{
  private SeoService $seoService;
  private PageService $pageService;
  private PasswordSetNewService $setNewPassService;

  public function __construct(SeoService $seoService, PasswordSetNewService $setNewPassService)
  {
    parent::__construct(); // Важно!
    $this->seoService = $seoService;
    $this->pageService = new PageService();
    $this->setNewPassService = $setNewPassService;
  }

  
  public function index($routeData)
  {
      $email = '';
      $resetCode = '';
      $newPasswordReady = false;

      // 1. Обработка отправки формы (POST)
      if (!empty($_POST['set-new-password'])) {
          $email = $_POST['email'] ?? '';
          $resetCode = $_POST['resetCode'] ?? '';
          $password = $_POST['password'] ?? '';

          $userModel = $this->setNewPassService->findUserByEmail($email);

          if ($userModel) {
            $isValidCode = $this->setNewPassService->isValidRecoveryCode($email, $resetCode);

            if ($isValidCode) {
              $this->setNewPassService->updateUserPassword($password, $email);

              $this->flash->pushSuccess('Пароль был успешно изменён');
              $newPasswordReady = true;
            } else {
              $this->flash->pushError('Неверный код восстановления');
            }
          } else {
              $this->flash->pushError('Пользователь не найден');
          }
      }

      // 2. Переход по ссылке из письма (GET)
      else if (!empty($_GET['email']) && !empty($_GET['code'])) {
          $email = $_GET['email'];
          $resetCode = $_GET['code'];

          $userModel = $this->setNewPassService->findUserByEmail($email);

          if (!$userModel) {
              $this->flash->pushError('Пользователь не найден');
              $this->redirect('lost-password');
          }

          if (!$this->setNewPassService->isValidRecoveryCode($email, $resetCode)) {
              $this->flash->pushError('Неверный или просроченный код восстановления');
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
    $seo = $this->seoService->getSeoForPage('profile-edit', $pageModel);
    
    $pageTitle = "Установить новый пароль";
    $pageClass = "authorization-page";

    ob_start();
    include ROOT . 'views/login/set-new-password.tpl';
    $content = ob_get_contents();
    ob_end_clean();

    include ROOT . "views/_page-parts/_head.tpl";
    include ROOT . "views/login/login-page.tpl";
    include ROOT . "views/_page-parts/_foot.tpl";
  }

}

