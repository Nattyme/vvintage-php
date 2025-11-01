<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Security;

/** Базовый контроллер страниц*/
use Vvintage\Controllers\Base\BaseController;

use Vvintage\Services\SEO\SeoService;
use Vvintage\Services\Page\PageService;
use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Security\PasswordSetNewService;
use Vvintage\Services\Validation\PasswordSetNewValidator;
use Vvintage\Services\Session\SessionService;
use Vvintage\Services\AdminPanel\AdminPanelService;

final class PasswordSetNewController extends BaseController 
{
  public function __construct(
    protected SessionService $sessionService, 
    protected AdminPanelService $adminPanelService,
    protected PageService $pageService, 
    protected FlashMessage $flash, 
    private SeoService $seoService, 
    private PasswordSetNewService $setNewPassService
  )
  {
    parent::__construct($sessionService, $adminPanelService, $pageService, $flash); // Важно!
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
              header("Location: " . HOST . "lost-password");
              exit;
          }

          if (!$this->setNewPassService->isValidRecoveryCode($email, $resetCode)) {
              $this->flash->pushError('Неверный или просроченный код восстановления');
              $this->redirect-('lost-password');
              exit;
          }
      }

      // Иначе — редирект на форму восстановления
      else {
        $this->redirect-('lost-password');
        exit;
      }

      // Отображение формы
      $this->renderForm($routeData ?? [], $newPasswordReady, $email, $resetCode);
  }


  private function renderForm($routeData, bool $newPasswordReady = false)
  {
    // Название страницы
    $page = $this->pageService->getPageBySlug($routeData->uriModule);
    $pageModel = $this->pageService->getPageModelBySlug( $routeData->uriModule );
    $seo = $this->seoService->getSeoForPage('profile-edit', $pageModel);
    
    $pageTitle = "Установить новый пароль";
    $pageClass = "authorization-page";

    $currentLang =  $this->pageService->currentLang;
    $languages = $this->pageService->languages;

    ob_start();
    include ROOT . 'views/login/set-new-password.tpl';
    $content = ob_get_contents();
    ob_end_clean();

    include ROOT . "views/_page-parts/_head.tpl";
    include ROOT . "views/login/login-page.tpl";
    include ROOT . "views/_page-parts/_foot.tpl";
  }

}

