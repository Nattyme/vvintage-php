<?php
// $notes должен быть передан в layout, например из контроллера
$errors = $flash->get('errors');

if (!empty($errors)) :
    foreach ($errors as $error) :
        ?>
        <div class="notifications<?php echo !empty($error['desc']) ? ' notifications__title--with-message' : ''; ?>">
            
            <div class="notifications__title notifications__title--error">
                <?php echo h($error['title']); ?>
            </div>

            <?php if (!empty($error['desc'])): ?>
                <div class="notifications__message">
                    <p><?php echo h($error['desc']); ?></p>
                    <?php if (!empty($error['flag'])): ?>
                      <span class='select-icon'>
                        <img src="<?php echo h($error['flag']); ?>" alt="flag" class="notifications__flag">
                      </span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div>
        <?php
    endforeach;
endif;
?>
