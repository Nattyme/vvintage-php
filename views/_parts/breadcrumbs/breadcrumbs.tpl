<?php
  if (isset($category)) {
    $breadcrumbs[] = ['title' => $category['title'], 'url' => HOST . 'shop/' . $category['id']];
  }

  if (isset($product) && !isset($products)) {
    $breadcrumbs[] = ['title' => $product->getTitle(), 'url' => '#'];
  }
?>

<nav class="breadcrumbs" >
    <a href="<?php echo HOST;?>" class="breadcrumb ">Главная</a> 
    <?php echo '<span> &#8212; </span>';?>
    <a href="<?php echo HOST;?>shop" class="breadcrumb ">Все товары</a> 

    <?php foreach ($breadcrumbs as $index => $item) {
        $isLast = $index === array_key_last($breadcrumbs);
        echo '<span> &#8212; </span>';

        if ($isLast) {
          echo '<span class="breadcrumb breadcrumb--active">' . h($item['title']) . '</span>';
        } else {
          echo '<a href="' . h($item['url']) . '" class="breadcrumb">' . h($item['title']) . '</a>';
        }
      }
    ?>
</nav>




