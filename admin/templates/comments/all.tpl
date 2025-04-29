<div class="admin-page__content-form">
  <div class="admin-form" style="max-width: unset; width: auto;">
    <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
    <?php include ROOT . "admin/templates/components/success.tpl"; ?>

    <div class="admin-form__item d-flex justify-content-between mb-20">
      <h2 class="heading">Комментарии</h2>
    </div>

    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Аватар</th>
          <th>Отправитель</th>
          <th>Комментарий</th>
          <th>К записи</th>
          <th>Время</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($comments as $comment) : ?>

          <tr <?php echo $comment['status'] === 'new' ? 'class="message-new"' : NULL;?>>
            <td>
              <?php echo $comment['id'];?>
            </td>

            <td>
              <div class="comment__avatar">
                <div class="avatar-small">
                  <a class="link-above-others" href="<?php echo HOST . 'profile/' . $comment['user_id'];?>">

                    <?php if ( !empty($comment['avatar_small'])) : ?>
                      <img src="<?php echo HOST . 'usercontent/avatars/' . $comment['avatar_small'];?>" alt="Аватарка" />
                    <?php else : ?>
                      <div class="avatar-small">
                        <img src="<?php echo HOST;?>usercontent/avatars/no-avatar.svg" alt="Аватарка" />
                      </div>
                    <?php endif; ?>
                  </a>

                </div>
              </div>
            </td>

            <td>
              <a class="link-to-page" href="<?php echo HOST;?>admin/comment?id=<?php echo $comment['id'];?>">
                <?php echo !empty($comment['name']) ? $comment['name'] . ' ' . $comment['surname'] : "Аноним";?>
              </a>
            </td>
            <td class="block-text">
              <p class="block-text__desc">
                <?php echo $comment['text'];?>
              </p>
            </td>
            <td class="block-text">
              <a class="link-above-others block-text__desc" href="<?php echo HOST . 'blog/' . $comment['post_id'];?>">
                <?php echo $comment['title'];?>
              </a>
            </td>
            <td>
              <?php echo rus_date("j. m. Y. H:i", $comment['timestamp']); ?>
            </td>
            <td>
              <a href="<?php echo HOST . "admin/";?>comments?action=delete&id=<?php echo $comment['id'];?>" class="icon-delete"></a>
            </td>
          </tr>
        <?php endforeach; ?> 
      </tbody>
    </table>
    
    <!-- Пагинация -->
    <div class="admin-form__item pt-40">
      <div class="section-pagination">
          <?php include ROOT . "admin/templates/_parts/pagination/_pagination.tpl"; ?>
      </div>
    </div>
    <!--// Пагинация -->
  </div>
</div>
