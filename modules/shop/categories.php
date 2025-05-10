<?php 
$category = R::load('categories', $uriGetParam);

if ($category) {
  $pageTitle = "Категория: {$category['title']}";
  // $settings['card_on_page_shop']

  // 1. Получаем подкатегории
  $subCategories = R::findAll('categories', 'parent_id = ?', [$uriGetParam]);

  // 2. Извлекаем их ID в массив
  $subCategoryIds = array_values(array_map(function($cat) {
    return $cat['id'];
  }, $subCategories));


  // Если вдруг нет подкатегорий — ищем по текущей категории
  if (empty($subCategoryIds)) {
      $subCategoryIds = [$uriGetParam];
  }

  $slotString = R::genSlots($subCategoryIds);
 
  // 3. Получаем все продукты с этими категориями
  $sql = "SELECT p.title,
                 p.id,
                 p.category,
                 p.brand,
                 p.price,
                 pi.filename
          FROM `products` p 
          LEFT JOIN `productimages` pi ON p.id = pi.product_id AND  pi.image_order = 1
          WHERE p.category IN ($slotString) 
          ORDER by p.id DESC";

  $products = R::getAll($sql, $subCategoryIds);

  // $pagination = pagination(9, 'products', ['category = ? ', [$uriGetParam]]);

  // $products = array();
  // foreach ($productsDB as $current_product) {
  //   // Получаем строки с категориями магазина
  //   $categories = R::find('categories', ' section LIKE ? ', ['shop']);
    
  //   $brands = R::find('brands');

  //   $product['id'] = $current_product->id;
  //   $product['title'] = $current_product->title;
  //   $product['cat'] = $current_product->cat;
  //   $product['brand'] = $current_product->brand;
  //   $product['cover_small'] = $current_product->cover_small;
  //   $product['price'] =$current_product->price;
  //   if ($current_product['cat'] === $categories[$current_product['cat']]['id']) {
  //     $current_product['cat'] = $categories[$current_product['cat']]['title'];
  //   }

  //   if ($current_product['brand'] === $brands[$current_product['brand']]['id']) {
  //     $current_product['brand'] = $brands[$current_product['brand']]['title'];
  //   }
  //   $product['cat_title'] = $current_product['cat'];
  //   $product['brand_title'] = $current_product['brand'];
  //   $products [] = $product;
  // }
} else {
  header('Location: ' . HOST . 'shop');
  exit();
}




// Подключение шаблонов страницы
include ROOT . "templates/_page-parts/_head.tpl";
include ROOT . "templates/_parts/_header.tpl";
include ROOT . "templates/shop/catalog.tpl";
include ROOT . "templates/_parts/_footer.tpl";
include ROOT . "templates/_page-parts/_foot.tpl";