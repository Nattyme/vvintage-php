<?php

declare(strict_types=1);

namespace Vvintage\Controllers\Shop;

use Vvintage\Models\Shop\Catalog;
use Vvintage\Routing\RouteData;
use Vvintage\Models\Settings\Settings;

require_once ROOT . "./libs/functions.php";

final class CatalogController
{
    public static function index(RouteData $routeData): void
    {
        // Получаем массив всех настроек
        $settings = Settings::all();

        $productsPerPage = 9;

        // Получаем параметры пагинации
        $pagination = pagination($productsPerPage, 'products');

        // Получаем продукты с учётом пагинации
        $products = Catalog::getAll($pagination);

        // Считаем, сколько всего товаров в базе (для отображения "Показано N из M")
        $totalProducts = Catalog::getTotalProductsCount();

        // Это кол-во товаров, показанных на этой странице
        // $shownProducts = $totalProducts - count($products);
        $shownProducts = (($pagination['page_number'] - 1) * 9) + count($products);

        $pageTitle = "Каталог товаров";

        // Хлебные крошки
        $breadcrumbs = [];


        // Передаем данные в view
        require ROOT . 'views/_page-parts/_head.tpl';
        require ROOT . 'views/_parts/_header.tpl';
        require ROOT . 'views/shop/catalog.tpl';
        require ROOT . 'views/_parts/_footer.tpl';
        require ROOT . 'views/_page-parts/_foot.tpl';
    }
}
