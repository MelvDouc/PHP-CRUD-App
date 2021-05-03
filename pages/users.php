<?php

  if(!checkSession("is_admin")) {
    exit("This is an admin-only page.");
  }

  require "./db.php";
  $users = $db->query("SELECT * FROM users;");

?>

<h2>Users</h2>

<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Username</th>
      <th>Email Address</th>
      <th>Profile Picture</th>
      <th>Register Date</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php while($user = $users->fetch()): extract($user); ?>
      <tr>
        <td class="id-link">
          <a href="./?profile&id=<?= $id ?>"><?= $id ?></a>
        </td>
        <td><?= $username ?></td>
        <td><?= $email ?></td>
        <td>
          <img
            height="50"
            src="./assets/img/<?= ($avatar) ? $avatar : "default.jpg" ?>"
            alt="<?= $username ?>'s profile picture"
          >
        </td>
        <td><?= $register_date ?></td>
        <td>
          <a href="./?update-profile&id=<?= $id ?>">
            <button>Edit</button>
          </a>
          <a href="./processing.php?delete-account&id=<?= $id ?>">
            <button class="btn-red">Delete</button>
          </a>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>