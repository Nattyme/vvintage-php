<div class="admin-page__content-form">
  <div class="admin-form" style="width: 900px;">
    <?php include ROOT . "admin/templates/components/errors.tpl"; ?>
    <?php include ROOT . "admin/templates/components/success.tpl"; ?>

    <div class="admin-form__item d-flex justify-content-between mb-20">
      <h2 class="heading">Пользователи</h2>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Имя</th>
          <th>Эл. почта</th>
          <th>Комментарии</th>
          <th>Роль</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $user) : ?>
          <tr>
            <td><?php echo $user['id'];?></td>
            <td>
              <a class="link-to-page" href="<?php echo HOST; ?>profile/<?php echo $user['id'];?>">
                <?php echo isset($user['name']) ? $user['name'] : 'Аноним' ;?>
              </a>
            </td>
            <td>
                <?php echo $user['email'];?>
            </td>
            <td>
                <?php echo $user['comments'];?>
            </td>
            <td>
              <?php echo $user['role'];?>
            </td>
            <td>
              <a href="<?php echo HOST;?>admin/user-block?id=<?php echo $user['id'];?>" class="icon-delete"></a>
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
