<?php 
// Подключаем readbean
use RedBeanPHP\R;

// Получаем товары, которые соответствуют товарам в корзине
if ( !empty($cart) ) {
  // Массив ids
  $ids = array_keys($cart);

  // Плейсхолдеры для запроса
  $slotString = R::genSlots($ids);

  // Находим продкуты и их главное изображений 
  $sql = "SELECT p.title,
                 p.id,
                 p.category,
                 p.brand,
                 p.price,
                 pi.filename
          FROM `products` p 
          LEFT JOIN `productimages` pi ON p.id = pi.product_id AND pi.image_order = 1
          WHERE p.id IN ($slotString)";

  $productsData = R::getAll($sql, $ids);

  $products = [];
  foreach ($productsData as $product) {
    $id = $product['id']; // получаем id из строки
    $products[$id] = $product; // сохраняем строку под ключом id
  }

} else {
  $products = array();
}

// Общая стоимость товаров в корзине
$cartTotalPrice = 0;
foreach ( $cart as $id => $quantity) {
  if(isset($products[$id])) {
    $cartTotalPrice = $cartTotalPrice + $products[$id]['price'] * $quantity;
  }

}

$pageTitle = "Корзина товаров";

// Хлебные крошки
$breadcrumbs = [
  ['title' => $pageTitle, 'url' => '#'],
];

// Подключение шаблонов страницы
include ROOT . "templates/_page-parts/_head.tpl";
include ROOT . "templates/_parts/_header.tpl";
include ROOT . "templates/cart/cart.tpl";
include ROOT . "templates/_parts/_footer.tpl";
include ROOT . "templates/_page-parts/_foot.tpl";