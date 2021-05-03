<ul>
  <li>
    <a href="./">Home</a>
  </li>

<?php
  if(checkSession("connected")):
?>
  
    <li>
      <a href="./?profile">Profile</a>
    </li>
  
<?php
  endif;
  if(!isset($_SESSION["connected"])):
?>
  
  <li>
   <a href="./?sign-in">Sign In</a>
  </li>
  <li>
    <a href="./?sign-up">Sign Up</a>
  </li>
  
<?php
  endif;
  if(checkSession("is_admin")):
?>
  
  <li>
    <a href="./?users">Users</a>
  </li>

<?php
  endif;
?>

</ul>