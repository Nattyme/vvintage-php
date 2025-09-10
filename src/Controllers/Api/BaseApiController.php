<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Api;

use Vvintage\Services\Session\SessionService;
use Vvintage\Contracts\User\UserInterface;
use Vvintage\Models\User\User;
// Пеервод на другие языки
use Vvintage\Config\LanguageConfig;


class BaseApiController 
{
    protected array $languages;
    protected string $currentLang;


    public function __construct() {
      $this->languages = LanguageConfig::getAvailableLanguages();
      $this->currentLang = LanguageConfig::getCurrentLocale();
      
      if (session_status() === PHP_SESSION_NONE) {
          session_start();
      }
    }

    // общий для всех API-контроллеров, ставит заголовки и код статуса.
    protected function jsonResponse(array $data, int $status = 200): void 
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit; // конец запроса
    }

    protected function isAdmin(): bool {
        $sessionService = new SessionService();
        $userModel = $sessionService->getLoggedInUser();
    
        if (!($userModel instanceof User) || $userModel->getRole() !== 'admin') {
     
            $this->jsonResponse(['error' => 'Недостаточно прав'], 401);
        }

        return true;
    }

    protected function success(array $data = [], int $status = 200): void 
    {
      $this->jsonResponse(['success' => true, 'data' => $data, 'errors' => []], $status);
    }

    protected function error(array $errors, int $status = 400): void 
    {
      $this->jsonResponse(['success' => false, 'data' => null, 'errors' => $errors], $status);
    }

    // автоматически парсит JSON или form-data.
    protected function getRequestData(): array 
    {
      $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

      if(stripos($contentType, 'application/json') !== false) {
        $raw = file_get_contents('php://input');
        return json_decode($raw, true) ?: [];
      }

      if(stripos($contentType, 'multipart/form-data') !== false) {
   
        return ['_text' => $_POST, '_files' => $_FILES];
      }

      return $_POST; // fallback
    }
}