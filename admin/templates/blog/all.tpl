<div class="admin-page__content-form">
  <div class="admin-form" style="width: 900px;">
    <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
    <?php include ROOT . "admin/templates/components/success.tpl"; ?>

    <div class="admin-form__item d-flex justify-content-between mb-20">
      <h2 class="heading">Блог - все записи</h2>
      <a class="secondary-button" href="<?php HOST;?>post-new">Добавить пост</a>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Название</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($posts as $post) : ?>
          <tr>
            <td><?php echo $post['id']; ?></td>
            <td>
              <a class="link-to-page" href="<?php echo HOST . "admin/"; ?>post-edit?id=<?php echo $post['id']; ?>">
                <?php echo $post['title']; ?>
              </a>
            </td>
            <td>
              <a href="<?php echo HOST . "admin/";?>post-delete?id=<?php echo $post['id'];?>" class="icon-delete"></a>
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
