<main class="inner-page">
  <section class="contacts">
    <div class="container">
      <!-- Заголовок и хлебные крошки -->
      <?php include ROOT . 'views/_parts/_inner-header.tpl'; ?>
  
      <div class="contacts__map-wrapper">
        <div class="contacts__map" id="map" style="width: 100%; height: 476px">
   
          <?php if (!empty($fields['map']['value'])): ?>
            <iframe 
              src="<?php echo $fields['map']['value'];?>" 
              width="600" height="450" 
              style="border:0;" 
              allowfullscreen="" 
              loading="lazy" 
              referrerpolicy="no-referrer-when-downgrade">
            </iframe>
          <?php else: ?>
            <p>Карта не добавлена</p>
          <?php endif; ?>
        </div>
      </div>

      <div class="contacts__widgets-wrapper">
        <div class="contacts__widget">
          <h3 class="contacts__widget__title h3">
            <?php echo h(__('contacts.contact.title', [], 'contacts'));?>
          </h3>
          <ul class="contacts__list">
            <?php if (!empty($fields['phone']['value'])): ?>
              <li class="contacts__item">
                <svg class="icon icon--phone">
                  <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#phone'; ?>"></use>
                </svg>
                <a href="tel:<?php echo h($fields['phone']['value']); ?>" class="contacts__link">
                  <?php echo h($fields['phone']['value']); ?>
                </a>
              </li>
            <?php endif; ?>

            <?php if (!empty($fields['email']['value'])): ?>
              <li class="contacts__item">
                <svg class="icon icon--mail">
                  <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#mail'; ?>"></use>
                </svg>
                <a href="mailto:<?php echo h($fields['email']['value']); ?>" class="contacts__link">
                  <?php echo h($fields['email']['value']); ?>
                </a>
              </li>
            <?php endif; ?>

            <?php if (!empty($fields['address']['value'])): ?>
              <li class="contacts__item">
                <svg class="icon icon--location">
                  <use href="<?php echo HOST . 'static/img/svgsprite/sprite.symbol.svg#location'; ?>"></use>
                </svg>
                <p><?php echo nl2br(h($fields['address']['value'])); ?></p>
              </li>
            <?php endif; ?>
          </ul>
        </div>

        <div class="contacts__widget">
          <h3 class="contacts__widget__title h3"><?php echo h(__('contacts.form.title', [], 'contacts'));?></h3>

          <?php include ROOT . "views/components/errors.tpl"; ?>
          <?php include ROOT . "views/components/success.tpl"; ?>

          <div class="contacts__form">
            <form action="<?php echo HOST . 'contacts'; ?>" class="form-contact" method="POST">
              <div class="form-input-wrapper">
                <input type="text" class="form-input input" placeholder="<?php echo h(__('contacts.form.name', [], 'contacts'));?>" name="name" />
                <input type="text" class="form-input input" placeholder="<?php echo h(__('contacts.form.email', [], 'contacts'));?>" name="email" />
                <input type="text" class="form-input input" placeholder="<?php echo h(__('contacts.form.phone', [], 'contacts'));?>" name="phone" />
              </div>

              <textarea class="form-textarea textarea" name="message" placeholder="<?php echo h(__('contacts.form.message', [], 'contacts'));?>"></textarea>

              <!-- CSRF-токен -->
              <input type="hidden" name="csrf" value="<?php echo h(csrf_token()); ?>">
              <!-- // CSRF-токен -->

              <div class="form-contact__button">
                <button class="button button--primary button--l" name="contact_submit" type="submit" value="submit">
                 <?php echo h(__('button.submit', [], 'buttons'));?>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
