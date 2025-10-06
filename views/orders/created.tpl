<main class="inner-page">
  <section class="order">
    <div class="container">
      <div class="order__header">
        <div class="section-title">
          <h1 class="h1">Заказ получен</h1>
        </div>
      
        <div class="breadcrumbs">
            <a href="#!" class="breadcrumb ">Главная</a> 
            <span>&mdash;</span> 
            <a href="#!" class="breadcrumb ">Оформление заказа</a> 
            <span>&mdash;</span>
            <a href="#!" class="breadcrumb breadcrumb--active">Заказ получен</a>
        </div>
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
            <a href="<?php echo HOST . 'main';?>" class="button button--outline button--l">На главную</a>
          </div>
        </div>
      </div>

    </div>
  </section>
</main>