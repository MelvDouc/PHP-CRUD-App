<?php
session_start();

require_once "./classes/HTMLContent.php";

$queryString = explode("&", $_SERVER["QUERY_STRING"])[0];
$title = "CRUD App";
if ($queryString !== "")
  $title .= " - " . ucwords(str_replace("-", " ", $queryString));

function checkSession($sessionKey)
{
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
    if (file_exists("./pages/$queryString.php")) :
      require_once "./pages/$queryString.php";
    else :
    ?>

      <p>Home page</p>


    <?php endif; ?>
  </main>

  <footer>
    <?php
    require_once "./inc/footer.inc.html";
    ?>
  </footer>
</body>

</html>