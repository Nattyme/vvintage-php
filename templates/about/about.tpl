<main class="inner-page">
  <section class="about-us">
    <div class="container">
      <div class="about-us__header">
        <div class="section-title">
          <h1 class="h1">О&#160;нас</h1>
        </div>

        <div class="breadcrumbs">
          <a href="<?php echo HOST . 'main';?>" class="breadcrumb ">Главная</a>
          <span>&#8212;</span>
          <a href="#!" class="breadcrumb breadcrumb--active">О&#160;компании</a>
        </div>
      </div>

      <div class="about-us__articles-wrapper">
        <article class="article">
          <div class="article__img">
            <picture>
              <source srcset="<?php echo HOST . 'static/img/about-page/01.webp 1x,' . 'static/img/about-page/01@2x.webp 2x';?>" type="image/webp" />
              <source srcset="<?php echo HOST . 'static/img/about-page/01.jpg 1x,' . 'static/img/about-page/01@2x.jpg 2x';?>" type="image/jpeg" />
              <img src="<?php echo HOST . 'static/img/about-page/01.jpg';?>" srcset="<?php echo HOST . 'static/img/about-page/01@2x.jpg'?>" alt="" />
            </picture>
          </div>
          <div class="article__content">
            <header class="article__title">
              <h2 class="h2">Что мы&#160;предлагаем</h2>
            </header>
            <div class="article__text">
              <p>
                VVintage&#160;&#8212; это сайт, который предлагает большой ассортимент винтажных вещей известных брендов из&#160;Европы (Франция, Италия,
                Бельгия, Испания) c&#160;доставкой на&#160;ваш адрес. Все товары находятся в&#160;Европе и&#160;высылаются покупателям в&#160;любую точку мира
                под заказ.
              </p>
              <p>
                У&#160;нас вы&#160;можете приобрести редкую парфюмерию, косметику, украшения, сумки, товары для дома, одежду и&#160;обувь. Также
                вы&#160;можете оставить нам заявку на&#160;поиск парфюмерных редкостей.
              </p>
              <p>
                Все товары вляются оригинальными товарами, которые продаются в&#160;Европе. Их&#160;происхождение гарантируется либо сертификатами
                аутенфикации, которые предоставляются вместе с&#160;товарами, либо, если это невозможно, теми площадками, с&#160;которых они выкупаются.
              </p>
            </div>
          </div>
        </article>
      </div>
    </div>
  </section>
  <section class="delivery">
    <div class="container">
      <div class="delivery__header">
        <div class="section-title">
          <h1 class="h1">Доставка</h1>
        </div>
      </div>

      <div class="delivery__content">
        <ul class="delivery__text">
          <li>
            <svg class="icon icon--payment">
              <use href="./img/svgsprite/sprite.symbol.svg#payment"></use>
            </svg>
            <div>Оплачивается из&#160;расчета 15 евро за&#160;1 кг.</div>
          </li>
          <li>
            <svg class="icon icon--note">
              <use href="./img/svgsprite/sprite.symbol.svg#note"></use>
            </svg>
            <div>Итоговая стоимость рассчитывается оператором при выставлении счета.</div>
          </li>
          <li>
            <svg class="icon icon--plane">
              <use href="./img/svgsprite/sprite.symbol.svg#plane"></use>
            </svg>
            <div>Доставка по&#160;всему миру.</div>
          </li>
          <li>
            <svg class="icon icon--check">
              <use href="./img/svgsprite/sprite.symbol.svg#check"></use>
            </svg>
            <div>Стоимость отправляемого товара может быть задекларирована в&#160;соответствии с&#160;пожеланиями покупателя.</div>
          </li>
        </ul>

        <div class="delivery__img">
          <picture>
            <source srcset="<?php echo HOST . 'static/img/about-page/happy-postman_wide.webp 1x,' . 'static/img/about-page/happy-postman_wide@2x.webp 2x';?>" type="image/webp" />
            <source srcset="<?php echo HOST . 'static/img/about-page/happy-postman_wide.jpg 1x,' . 'static/img/about-page/happy-postman_wide@2x.jpg 2x';?>" type="image/jpeg" />
            <img src="<?php echo HOST . 'static/img/about-page/happy-postman_wide.jpg';?>" srcset="<?php echo HOST . 'static/img/about-page/happy-postman_wide@2x';?>" alt="happy-postman" />
          </picture>
        </div>
      </div>
    </div>
  </section>
  <section class="prices">
    <div class="container">
      <div class="prices__header">
        <div class="section-title">
          <h1 class="h1">Тарифы</h1>
        </div>
      </div>

      <div class="prices__cards">
        <div class="cards-row">
          <div class="price-card">
            <div class="price-card__body">
              <div class="price-card__header">
                <h2 class="price-card__title">Россия</h2>
                <p>ОТ&#160;<span class="text-bold text-accent">35 &#8364;</span></p>
              </div>
              <div class="price-card__text">
                <p>Подробнее о&#160;тарифах</p>
              </div>
      
              <div class="price-card__table">
                <div class="price-card__plans-row">
                  <div class="price-card__plan price-card__plan--1">
                    <div>1 кг</div>
                    <div>35&#8364;</div>
                  </div>
                  <div class="price-card__plan price-card__plan--2">
                    <div>2 кг</div>
                    <div>37&#8364;</div>
                  </div>
                  <div class="price-card__plan price-card__plan--3">
                    <div>3 кг</div>
                    <div>44&#8364;</div>
                  </div>
                  <div class="price-card__plan price-card__plan--4">
                    <div>4 кг</div>
                    <div>48&#8364;</div>
                  </div>
                  <div class="price-card__plan price-card__plan--5">
                    <div>5 кг</div>
                    <div>50&#8364;</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="price-card">
            <div class="price-card__body">
              <div class="price-card__header">
                <h2 class="price-card__title">Другие страны</h2>

                <p>ОТ&#160;<span class="text-bold text-accent">37 &#8364;</span></p>
              </div>
              <div class="price-card__text">
                <p>Подробнее о&#160;тарифах</p>
              </div>
              
              <div class="price-card__table">
                <div class="price-card__plans-row">
                  <div class="price-card__plan price-card__plan--1">
                    <div>1 кг</div>
                    <div>37&#8364;</div>
                  </div>
                  <div class="price-card__plan price-card__plan--2">
                    <div>2 кг</div>
                    <div>44&#8364;</div>
                  </div>
                  <div class="price-card__plan price-card__plan--3">
                    <div>3 кг</div>
                    <div>48&#8364;</div>
                  </div>
                  <div class="price-card__plan price-card__plan--4">
                    <div>4 кг</div>
                    <div>50&#8364;</div>
                  </div>
                  <div class="price-card__plan price-card__plan--5">
                    <div>5 кг</div>
                    <div>54&#8364;</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</main>
