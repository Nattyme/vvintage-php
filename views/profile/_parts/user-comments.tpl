<section class="section bg-grey">
  <div class="container">
    <div class="section__title">
      <h2 class="heading">Комментарии пользователя </h2>
    </div>
    <div class="section__body">
      <div class="row justify-content-center">
        <div class="col-md-10">
          <?php 
            foreach ($comments as $comment) {
              include ROOT . "templates/profile/_parts/_comment.tpl";
            } 
          ?>
        </div>
      </div>
    </div>
  </div>
</section>
