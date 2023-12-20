<?php echo $this->render('./header.php',NULL,get_defined_vars(),0); ?>

<div class="container">
  <?php echo $this->render('./admin_nav.php',NULL,get_defined_vars(),0); ?>

  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">First</th>
        <th scope="col">Last</th>
        <th scope="col">Id</th>
      </tr>
    </thead>
    <tbody>

      <?php foreach (($userList?:[]) as $item[0]): ?>
        <tr>
          <td><a href="/flexapp/admin/chatroom?userId=<?= ($item[0]->user['Id']) ?>">To Chat: <?= (count($item[0]->messages)) ?></a> </td>
          <td><?= ($item[0]->user['first_name']) ?> </td>
          <td><?= ($item[0]->user['last_name']) ?></td>
          <td><?= ($item[0]->user['Id']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php echo $this->render('./footer.php',NULL,get_defined_vars(),0); ?>