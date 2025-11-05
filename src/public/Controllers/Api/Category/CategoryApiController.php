<?php
declare(strict_types=1);

namespace Vvintage\public\Controllers\Api\Category;

use Vvintage\public\Controllers\Api\BaseApiController;
use Vvintage\public\Services\Category\CategoryService;
use Vvintage\Serializers\CategoryApiSerializer;


class CategoryApiController extends BaseApiController
{
    private CategoryService $service;
    private CategoryApiSerializer $serializer;

    public function __construct()
    {
      parent::__construct(); // Важно!
      $this->service = new CategoryService($this->languages, $this->currentLang); 
      $this->serializer = new CategoryApiSerializer();
    } 


    //  Метод сам выведет получит и выведет данные через echo и заголовки.
    public function getMainCategories(): void
    {
        try {
            // Вызов метода сервиса, который возвращает массив главных категорий.
            $categories = $this->service->getMainCategoriesArray();

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

    public function getSubCategories(?int $parent_id = null): void
    {
        try {
            // Вызов метода сервиса, который возвращает массив главных категорий.
            $categories = $this->service->getSubCategoriesArray($parent_id);

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
            // Вызов метода сервиса, который возвращает массив все категорий.
            $categories = $this->service->getAllCategoriesArrayApi();


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

    public function getOne(int $id): void
    {
      $category = $this->service->getCategoryById($id);


      if (!$category) {
        $this->error(['Категория не найдена'], 404);
      }

      $this->success(['category' => $this->serializer->toItem($category)]);
  
    }
}
