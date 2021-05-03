<?php
if(!checkSession("connected")) {
  echo "You're not logged in";
  exit;
}
?>

<h2>Update Password</h2>

<form action="./processing.php?update-password" method="POST">

  <input type="password" name="old_pwd" placeholder="Current password">

  <input type="password" name="new_pwd1" placeholder="Enter new password">

  <input type="password" name="new_pwd2" placeholder="Confirm new password">

  <input type="submit" value="Submit">

</form>