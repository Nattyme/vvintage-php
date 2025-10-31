 <div class="footer__top">
  <div class="footer__topics">
    <div class="footer__topics-header">
        <?php echo h(__('blog.cats.sub.view.all', [], 'blog'));?>
    </div>
    <ul class="topics-list">

      <?php foreach( $navigation['footer'] as $category) : ?>
        <li class="topics-list__item">
          <a class="topics-list__link" href="#">
            <?php echo h($category->title); ?>
          </a>
        </li>
      <?php endforeach; ?>
      
    </ul>
  </div> 
</div>