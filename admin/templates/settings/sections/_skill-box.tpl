<h3 class="admin-section-title">Список технологий</h3>

<div class="admin-form__item skill-box">
  <label class="checkbox__item">
      <input
          class="checkbox__btn"
          type="checkbox"
          name="design_on"
          <?php echo !empty($settings['design_on']) ? 'checked' : NULL;  ?>
      >
      <span class="checkbox__label"><strong>UI/UX design</strong></span>
  </label>
  <label class="checkbox__item">
      <input
          class="checkbox__btn"
          type="checkbox"
          name="html_on"
          <?php echo !empty($settings['html_on']) ? 'checked' : NULL;  ?>
      >
      <span class="checkbox__label"><strong>HTML5</strong></span>
  </label>
  <label class="checkbox__item">
      <input
          class="checkbox__btn"
          type="checkbox"
          name="css_on"
          <?php echo !empty($settings['css_on']) ? 'checked' : NULL;  ?>
      >
      <span class="checkbox__label"><strong>CSS3</strong></span>
  </label>
  <label class="checkbox__item">
      <input
          class="checkbox__btn"
          type="checkbox"
          name="js_on"
          <?php echo !empty($settings['js_on']) ? 'checked' : NULL;  ?>
      >
      <span class="checkbox__label"><strong>JS</strong></span>
  </label>
  <label class="checkbox__item">
      <input
          class="checkbox__btn"
          type="checkbox"
          name="php_on"
          <?php echo !empty($settings['php_on']) ? 'checked' : NULL;  ?>
      >
      <span class="checkbox__label"><strong>PHP</strong></span>
  </label>
  <label class="checkbox__item">
      <input
          class="checkbox__btn"
          type="checkbox"
          name="wp_on"
          <?php echo !empty($settings['wp_on']) ? 'checked' : NULL;  ?>
      >
      <span class="checkbox__label"><strong>WordPress</strong></span>
  </label>
</div>

