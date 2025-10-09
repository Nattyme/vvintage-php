<main class="inner-page">
  <section class="order">
    <div class="container">
      <div class="order__header">
        <div class="section-title">
          <h1 class="h1"><?php echo h($pageTitle);?></h1>
        </div>
      
        <?php include ROOT . 'views/_parts/breadcrumbs/breadcrumbs.tpl';?>
      </div>

      <div class="order__body">
        <div class="order__row">
          <div class="order__notification">
            <div class="order__img">
              <img src="<?php echo HOST . 'static/img/svgsprite/stack/svg/sprite.stack.svg#success';?>" alt="success">
            </div>
            <div class="order__text">
              <p class="order__title"><?php echo h(__('order.success', [], 'order'));?></p>
              <p class="order__message"><?php echo h(__('order.contact_soon', [], 'order'));?></p>
            </div>
  
          </div>
          <div class="order__button">
            <a href="<?php echo HOST . 'main';?>" class="button button--outline button--l"><?php echo h(__('button.goto.main', [], 'buttons'));?></a>
          </div>
        </div>
      </div>

    </div>
  </section>
</main>