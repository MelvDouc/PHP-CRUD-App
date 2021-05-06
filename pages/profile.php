<?php
if (!checkSession("connected")) :
  exit("You're not logged in.");
endif;

require "./db.php";
$id = $_SESSION["userID"];
if (checkSession("is_admin") && isset($_GET["id"]))
  $id = (int)$_GET["id"];

$user = $db->query("SELECT * FROM users WHERE id = $id;");
$user = $user->fetch();

if (!$user)
  exit("No user with this ID.");

extract($user);
$imgSrc = (!$avatar) ? "default.jpg" : $avatar;

$idForAdmin = new HTMLContent(checkSession("is_admin"), "&id=$id");

$userOnlyLinks = new HTMLContent(
  $id === $_SESSION["userID"],
  "<a href='./?update-password'><button>Update Password</button></a>
    <a href='./processing.php?sign-out'><button>Log Out</button></a>",
);

$deleteAccountButton = new HTMLContent(
  checkSession("is_admin"),
  "<a href='./processing.php?delete-account&id=$id'>
    <button class='btn-red'>Delete Account</button>
    </a>"
);
?>

<h2><?= $username ?>'s Profile</h2>

<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Username</th>
      <th>Email Address</th>
      <th>Profile Picture</th>
      <th>Register Date</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><?= $user["id"] ?></td>
      <td><?= $username ?></td>
      <td><?= $email ?></td>
      <td>
        <img height="50" src="./assets/img/<?= $imgSrc ?>" alt="<?= $username ?>'s Profile Picture">
      </td>
      <td><?= $register_date ?></td>
    </tr>
  </tbody>
</table>

<a href="./?update-profile<?php $idForAdmin->display(); ?>"><button>Update Profile</button></a>

<?php
$userOnlyLinks->display();
$deleteAccountButton->display();
?>