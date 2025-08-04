<div class="admin-page__content-form">
  <div class="admin-form" style="width: 900px;">
    <?php include ROOT . "views/components/errors.tpl"; ?>
    <?php include ROOT . "views/components/success.tpl"; ?>

    <div class="admin-form__item d-flex justify-content-between mb-20">
      <h2 class="heading">Пользователи</h2>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Имя</th>
          <th>Эл. почта</th>
          <!-- <th>Комментарии</th> -->
          <th>Роль</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $user) : ?>
          <tr>
            <td><?php echo h( $user->getId() ) ;?></td>
            <td>
              <a class="link-to-page" href="<?php echo HOST; ?>profile/<?php echo h( $user->getId() ) ;?>">
                <?php echo !empty($user->getName()) ? h($user->getName()) : 'Аноним' ;?>
              </a>
            </td>
            <td>
                <?php echo  h($user->getEmail());?>
            </td>
            <!-- <td> -->
                <!-- <?php /** echo  $user['comments']; */?> -->
            <!-- </td> -->
            <td>
                <?php echo  h($user->getRole());?>
            </td>
            <td>
              <a href="<?php echo HOST;?>admin/user-block?id=<?php echo h( $user->getId() );?>" class="icon-delete"></a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <!-- Пагинация -->
    <div class="admin-form__item pt-40">
      <div class="section-pagination">
          <?php include ROOT . "views/_parts/pagination/_pagination.tpl"; ?>
      </div>
    </div>
    <!--// Пагинация -->
  </div>
</div>
