<?php
  if(checkSession("connected"))
    exit("You're already logged in.");
?>

<h2>Sign Up</h2>

<form action="./processing.php?sign-up" method="POST">

  <input type="text" name="username" placeholder="Username">

  <input type="email" name="email" placeholder="Email address">

  <input type="password" name="pwd1" placeholder="Password">

  <input type="password" name="pwd2" placeholder="Confirm password">

  <button type="submit">Submit</button>

</form>

<p>Already have an account? <a href="./?sign-in">Sign in here.</a></p>