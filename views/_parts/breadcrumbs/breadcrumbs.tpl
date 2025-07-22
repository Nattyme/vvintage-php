<nav class="breadcrumbs">
  <?php foreach ($breadcrumbs as $index => $item): ?>
    <?php if ($index > 0): ?>
      <span> &#8212; </span>
    <?php endif; ?>

    <?php if ($index === array_key_last($breadcrumbs)): ?>
      <span class="breadcrumb breadcrumb--active"><?php echo h($item['title']); ?></span>
    <?php else: ?>
      <a href="<?php echo h($item['url']); ?>" class="breadcrumb"><?php echo h($item['title']); ?></a>
    <?php endif; ?>
  <?php endforeach; ?>
</nav>
