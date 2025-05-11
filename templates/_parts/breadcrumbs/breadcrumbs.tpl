<?php

if (isset($category)) {
  $breadcrumbs[] = ['title' => $category['title'], 'url' => HOST . 'shop/' . $category['id']];
}

if (isset($product) && !isset($products)) {
  $breadcrumbs[] = ['title' => $product['title'], 'url' => '#'];
}
?>

<nav class="breadcrumbs" >
    <a href="<?php echo HOST;?>" class="breadcrumb ">Главная</a> 

    <?php foreach ($breadcrumbs as $index => $item) {
        $isLast = $index === array_key_last($breadcrumbs);
        echo '<span>&#8212;</span>';

        if ($isLast) {
          echo '<span class="breadcrumb breadcrumb--active">' . htmlspecialchars($item['title']) . '</span>';
        } else {
          echo '<a href="' . htmlspecialchars($item['url']) . '" class="breadcrumb">' . htmlspecialchars($item['title']) . '</a>';
        }
      }
    ?>
</nav>




