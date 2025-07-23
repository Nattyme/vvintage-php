<div class="page-blog">
  <div class="container">
    <nav class="page-blog__nav">
    <?php include ROOT . 'views/blog/nav/nav.tpl';?>
    </nav>
    <div class="page-blog__content">
      <main class="page-blog__body">
        <?php echo $content; ?>
      </main>
      <?php include ROOT . 'views/blog/_parts/_sidebar/_sidebar.tpl';?>
    </div>

  </div>
</div>

