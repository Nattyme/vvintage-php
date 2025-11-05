<?php
declare(strict_types=1);

namespace Vvintage\Public\Services\Page;

use Vvintage\Routing\RouteData;
use Vvintage\Public\Services\Page\PageService;

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
        $pageService = new PageService();
        $mainPageModel = $pageService->getPageModelBySlug( 'main' );
        $mainPageTranslations = $mainPageModel->getCurrentTranslations();

        // Главная всегда первая
        $breadcrumbs[] = ['title' => $mainPageTranslations['title'], 'url' => '/'];

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
                $pageModel = $pageService->getPageModelBySlug( $part );

                if( $pageModel) {
                  $pageTranslations = $pageModel->getCurrentTranslations();
                  $title = $pageTranslations['title'];
                  $breadcrumbs[] = ['title' => $title, 'url' => $path];
                } 
              
                // Используем отображаемое имя из map или first сегмента
                // $title = $this->titlesMap[$part] ?? ucfirst($part);
             
               
            }
        }

        return $breadcrumbs;
    }
}

