<main class="inner-page">

  <section class="about-us">
    <div class="container">
      <div class="about-us__header">
        <div class="section-title">
          <h1 class="h1"><?php echo $pageTitle;?></h1>
        </div>
        <?php include ROOT . 'views/_parts/breadcrumbs/breadcrumbs.tpl'; ?>
      </div>

      <div class="about-us__articles-wrapper">
        <article class="article">
          <div class="article__img" data-aos="fade-right" data-aos-duration="2000">>
            <picture>
              <!-- <source srcset="<?php echo HOST . 'static/img/about-page/is-perfuming-front-window.jpg 1x,' . 'static/img/about-page/is-perfuming-front-window.jpg 1x';?>" type="image/webp" /> -->
              <!-- <source srcset="<?php echo HOST . 'static/img/about-page/is-perfuming-front-window.jpg 1x,' . 'static/img/about-page/is-perfuming-front-window.jpg 1x';?>" type="image/jpeg" /> -->
              <img src="<?php echo HOST . 'static/img/about-page/is-perfuming-front-window.jpg';?>" srcset="<?php echo HOST . 'static/img/about-page/is-perfuming-front-window.jpg'?>" alt="" />
            </picture>
            <span class="article__decor petal-decor petal-decor--medium"></span>
            <span class="article__decor petal-decor petal-decor--small"></span>
          </div>
          <div class="article__content">
            <header class="article__title">
              <h2 class="h2"><?php echo h($fields['intro_title']['value']);?></h2>
            </header>
            <div class="article__text"><?php echo  $fields['intro_text']['value'];?></div>
          </div>
        </article>
      </div>
    </div>
  </section>
 
</main>
