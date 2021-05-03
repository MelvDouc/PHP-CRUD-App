<?php
  if(!checkSession("connected")):
    echo "You're not logged in.";
    exit;
  endif;
  
  require_once "./db.php";
  $id = $_SESSION["userID"];
  if(checkSession("is_admin") && isset($_GET["id"]))
    $id = $_GET["id"];
  
  $user = $db->query("SELECT * FROM users WHERE id = $id;");
  $user = $user->fetch();
  extract($user);
  $imgSrc = (!$avatar) ? "default.jpg" : $avatar;
?>

<h2>Update <?= $username ?>'s Profile</h2>

<img
  height="100"
  src="./assets/img/<?= $imgSrc ?>"
  alt="<?= $username ?>'s Profile Picture"
>

<form
  action="./processing.php?update-profile&id=<?= $id ?>"
  method="POST"
  enctype="multipart/form-data"
>

  <input type="text" name="username" placeholder="<?= $username ?>">
  
  <input type="email" name="email" placeholder="<?= $email ?>">
  
  <input type="file" name="avatar">
  
  <button type="submit">Submit</button>

</form>