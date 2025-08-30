<?php
// $notes должен быть передан в layout, например из контроллера
$success = $flash->get('success');

if (!empty($success)) :
    foreach ($success as $note) :
        ?>
        <div class="notifications<?php echo !empty($note['desc']) ? ' notifications__title--with-message' : ''; ?>">
            
            <div class="notifications__title notifications__title--success">
                <?php echo h($note['title']); ?>
            </div>

            <?php if (!empty($note['desc'])): ?>
                <div class="notifications__message">
                    <p><?php echo h($note['desc']); ?></p>
                    <?php if (!empty($note['flag'])): ?>
                      <span class='select-icon'>
                        <img src="<?php echo h($note['flag']); ?>" alt="flag" class="notifications__flag">
                      </span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div>
        <?php
    endforeach;
endif;
?>
