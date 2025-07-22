<?php
declare(strict_types=1);

namespace Vvintage\Services\Page;

use Vvintage\Routing\RouteData;

class Breadcrumbs
{
    // Сопоставление сегментов пути и названий для хлебных крошек
    private array $titlesMap = [
        'catalog' => 'Каталог',
        'cart' => 'Корзина',
        'shop' => 'Каталог',
        'product' => 'Товар',
        // добавляй свои названия
    ];

    public function generate(RouteData $routeData, string $currentPageTitle = ''): array
    {
        $breadcrumbs = [];

        // Главная всегда первая
        $breadcrumbs[] = ['title' => 'Главная', 'url' => '/'];

        // Получаем части URI
        $uriParts = explode('/', trim($routeData->uri, '/'));
        $path = '';

        // Добавляем все части, кроме последней, как ссылки
        for ($i = 0; $i < count($uriParts); $i++) {
            $part = $uriParts[$i];
            $path .= '/' . $part;

            // Для последнего элемента ставим заголовок из параметра $currentPageTitle, если он передан
            if ($i === count($uriParts) - 1 && $currentPageTitle !== '') {
                $title = $currentPageTitle;
                // Для последней страницы хлебная крошка обычно не является ссылкой
                $breadcrumbs[] = ['title' => $title, 'url' => ''];
            } else {
                // Используем отображаемое имя из map или ucfirst сегмента
                $title = $this->titlesMap[$part] ?? ucfirst($part);
                $breadcrumbs[] = ['title' => $title, 'url' => $path];
            }
        }

        return $breadcrumbs;
    }
}

