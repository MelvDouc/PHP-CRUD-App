<?php
  session_start();

  $queryString = explode("&", $_SERVER["QUERY_STRING"])[0];
  $title = "CRUD App";
  if($queryString !== "")
    $title .= " - " . ucwords(str_replace("-", " ", $queryString));

  function checkSession($sessionKey) {
    return isset($_SESSION[$sessionKey]) && $_SESSION[$sessionKey];
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./assets/style.css">
  <title><?= $title ?></title>
</head>
<body>

  <header>
    <h1>CRUD App</h1>
    <nav>
<?php require_once "./inc/nav.inc.php"; ?>
    </nav>
  </header>


  <main>
<?php
  if(file_exists("./pages/$queryString.php")):
    require_once "./pages/$queryString.php";
  else:
?>

  <p>Home page</p>


<?php endif; ?>
  </main>
  
  <footer>
    <p>Melvin Doucet &copy; 2021</p>
    <ul id="icons">
      <li>
        <a href="https://github.com/MelvDouc?tab=repositories">
          <i class="bi bi-github"></i>
        </a>
      </li>
      <li>
        <a href="https://www.linkedin.com/in/melvin-doucet-b11931114/">
          <i class="bi bi-linkedin"></i>
        </a>
      </li>
      <li>
        <a href="https://www.youtube.com/channel/UC9BJqAqRlOJBAA0O4WYSmnw">
          <i class="bi bi-youtube"></i>
        </a>
      </li>
    </ul>
  </footer>
</body>
</html>