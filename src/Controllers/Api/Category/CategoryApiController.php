<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Api\Category;

use Vvintage\Controllers\Base\BaseController;
use Vvintage\Services\Category\CategoryService;

class CategoryApiController extends BaseController
{
    private CategoryService $categoryService;

    public function __construct()
    {
      parent::__construct(); // Важно!
      $this->categoryService = new CategoryService($this->languages, $this->currentLang); 
    } 

    // public function getAll()
    // {
    //     header('Content-Type: application/json; charset=utf-8');
    //     echo json_encode(PostCategory::getAll(), JSON_UNESCAPED_UNICODE);
    // }

    // public function getByMainId($mainId)
    // {
    //     header('Content-Type: application/json; charset=utf-8');
    //     echo json_encode(PostCategory::getByMainId($mainId), JSON_UNESCAPED_UNICODE);
    // }

    //  Метод сам выведет получит и выведет данные через echo и заголовки.
    public function getMainCategories(): void
    {
        try {
            // Вызов метода сервиса, который возвращает массив главных категорий.
            $categories = $this->categoryService->getMainCategoriesArray();

            // Отправляем заголовок HTTP, говорящий браузеру (или клиенту API), что ответ — это JSON в кодировке UTF-8.
            header('Content-Type: application/json; charset=utf-8');

            // Преобразуем массив категорий в JSON-строку и отправляем клиенту.
            // Флаг JSON_UNESCAPED_UNICODE нужен, чтобы кириллица и другие юникод символы выводились "как есть", без \uXXXX кодирования
            echo json_encode($categories, JSON_UNESCAPED_UNICODE);

        } 

        // Если в блоке try случилась ошибка — переходим сюда.
        // \Throwable — базовый тип для всех ошибок и исключений в PHP, это универсальный способ поймать любую проблему.
        catch (\Throwable $e) {
            // Устанавливаем HTTP-код ответа — 500 Internal Server Error (внутренняя ошибка сервера).
            // Клиент (например, браузер или фронтенд) поймёт, что запрос завершился неудачей.
            http_response_code(500);

            // Формируем JSON с описанием ошибки — ключ error = true, и сообщение из исключения.
            // Это поможет клиенту понять, что произошло, и при необходимости показать пользователю понятное сообщение.
            echo json_encode([
                'error' => true,
                'message' => $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
    }

    public function getAllCategories(): void
    {
        try {
            // Вызов метода сервиса, который возвращает массив главных категорий.
            $categories = $this->categoryService->getAllCategoriesArray();

            // Отправляем заголовок HTTP, говорящий браузеру (или клиенту API), что ответ — это JSON в кодировке UTF-8.
            header('Content-Type: application/json; charset=utf-8');

            // Преобразуем массив категорий в JSON-строку и отправляем клиенту.
            // Флаг JSON_UNESCAPED_UNICODE нужен, чтобы кириллица и другие юникод символы выводились "как есть", без \uXXXX кодирования
            echo json_encode($categories, JSON_UNESCAPED_UNICODE);

        } 

        // Если в блоке try случилась ошибка — переходим сюда.
        // \Throwable — базовый тип для всех ошибок и исключений в PHP, это универсальный способ поймать любую проблему.
        catch (\Throwable $e) {
            // Устанавливаем HTTP-код ответа — 500 Internal Server Error (внутренняя ошибка сервера).
            // Клиент (например, браузер или фронтенд) поймёт, что запрос завершился неудачей.
            http_response_code(500);

            // Формируем JSON с описанием ошибки — ключ error = true, и сообщение из исключения.
            // Это поможет клиенту понять, что произошло, и при необходимости показать пользователю понятное сообщение.
            echo json_encode([
                'error' => true,
                'message' => $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
    }
}
