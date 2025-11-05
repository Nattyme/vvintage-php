<?php
declare(strict_types=1);

namespace Vvintage\public\Controllers\Api\Brand;

use Vvintage\public\Controllers\Api\BaseApiController;
use Vvintage\public\Controllers\Base\BaseController;
use Vvintage\public\Services\Brand\BrandService;

class BrandApiController extends BaseApiController
{
    private BrandService $service;

    public function __construct()
    {
      parent::__construct(); // Важно!
      $this->service = new BrandService($this->languages, $this->currentLang); 
    } 

    //  Метод сам выведет получит и выведет данные через echo и заголовки.
    public function getAllBrands(): void
    {
        try {
            // Вызов метода сервиса, который возвращает массив брендов.
            $brands = $this->service->getBrandsArray();
            
            // Отправляем заголовок HTTP, говорящий браузеру (или клиенту API), что ответ — это JSON в кодировке UTF-8.
            header('Content-Type: application/json; charset=utf-8');

            // Преобразуем массив категорий в JSON-строку и отправляем клиенту.
            // Флаг JSON_UNESCAPED_UNICODE нужен, чтобы кириллица и другие юникод символы выводились "как есть", без \uXXXX кодирования
            echo json_encode($brands, JSON_UNESCAPED_UNICODE);

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
