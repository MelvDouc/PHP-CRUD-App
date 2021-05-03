<?php

  session_start();
  require "./db.php";
  date_default_timezone_set("Europe/Paris");

  // ===== ===== ===== ===== =====
  // CREATE
  // ===== ===== ===== ===== =====

  if(isset($_GET["sign-up"])) {

    extract($_POST);

    if($username === "" || $email === "" || $pwd1 === "" || $pwd2 === "")
      exit("Please fill in every field.");

    $query = $db->query("SELECT * FROM users WHERE username = '$username';");
    $query = $query->fetch();
    if($query)
      exit("Username already taken.");

    $query = $db->query("SELECT * FROM users WHERE email = '$email';");
    $query = $query->fetch();
    if($query)
      exit("Email address in use.");

    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
      exit("Invalid email address.");

    if($pwd1 !== $pwd2)
      exit("Passwords don't match.");

    $request = $db->prepare(
      "INSERT INTO users (username, email, pwd, register_date) VALUES (?, ?, ?, NOW());"
    );

    $pwd = password_hash($pwd1, PASSWORD_DEFAULT);

    $request->bindParam(1, $username, PDO::PARAM_STR);
    $request->bindParam(2, $email, PDO::PARAM_STR);
    $request->bindParam(3, $pwd, PDO::PARAM_STR);

    $request->execute();

    header("Location: ./?sign-in");
    exit;

  }

// ===== ===== ===== ===== =====
// UPDATE
// ===== ===== ===== ===== =====

if(isset($_GET["update-profile"])) {

  extract($_POST);
  $id = (!$_SESSION["is_admin"]) ? $_SESSION["userID"] : $_GET["id"];
  $avatar = $_FILES["avatar"];

  if($username === "" && $email === "" && $avatar["name"] === "")
    exit("No changes made.");

  $query = $db->query("SELECT * FROM users WHERE username = '$username';");
  $query = $query->fetch();
  if($username !== "" && $query)
    exit("Username already taken.");

  $query = $db->query("SELECT * FROM users WHERE email = '$email';");
  $query = $query->fetch();
  if($email !== "" && $query)
    exit("Email address already in use.");
  
  if($avatar["name"] !== "" && $avatar["size"] > 2e6)
    exit("File size must not exceed 2&thinsp;MO.");

  if(
    $avatar["name"] !== ""
    && $avatar["type"] !== "image/jpg"
    && $avatar["type"] !== "image/jpeg"
    && $avatar["type"] !== "image/png"
  ) exit("Invalide file type.");

  if($avatar["name"] !== "") {
    if(!is_dir("./assets/img"))
      mkdir("./assets/img");
    $image_name = time() . "." . pathinfo($avatar["name"], PATHINFO_EXTENSION);
    move_uploaded_file($avatar["tmp_name"], "./assets/img/$image_name");
    $req = $db->prepare("UPDATE users SET avatar = ? WHERE id = $id;");
    $req->bindParam(1, $image_name, PDO::PARAM_STR);
    $req->execute();
  }

  if($username !== "") {
    $req = $db->prepare("UPDATE users SET username = ? WHERE id = $id;");
    $req->bindParam(1, $username, PDO::PARAM_STR);
    $req->execute();
  }
  
  if($email !== ""){
    $req = $db->prepare("UPDATE users SET email = ? WHERE id = $id;");
    $req->bindParam(1, $email, PDO::PARAM_STR);
    $req->execute();
  }

  header("Location: ./?profile&id=$id");
  exit;

}



if(isset($_GET["update-password"])) {

  extract($_POST);
  $db_pwd = $db->query("SELECT * FROM users WHERE id = " . $_SESSION["userID"]);
  $db_pwd = $db_pwd->fetch()["pwd"];

  if($old_pwd === "" || $new_pwd1 === "" || $new_pwd2 === "")
    exit("Please fill in every field.");

  if(!password_verify($old_pwd, $db_pwd))
    exit("Incorrect password.");

  if($new_pwd1 !== $new_pwd2)
    exit("New passwords don't match.");

  $req = $db->prepare("UPDATE users SET pwd = ? WHERE id = " . $_SESSION["userID"]);
  $new_pwd = password_hash($new_pwd1, PASSWORD_DEFAULT);
  $req->bindParam(1, $new_pwd, PDO::PARAM_STR);
  $req->execute();

  header("Location: ./?profile");
  exit;
}

// ===== ===== ===== ===== =====
// DELETE
// ===== ===== ===== ===== =====

if(isset($_GET["delete-account"])) {
  if(!isset($_SESSION["is_admin"]) || !$_SESSION["is_admin"])
    exit("No can do.");

  $id = $_GET["id"];
  $req = $db->prepare("DELETE FROM users WHERE id = $id;");
  $req->execute();

  header("Location: ./?users");
  exit;
}

// ===== ===== ===== ===== =====
// Other
// ===== ===== ===== ===== =====

if(isset($_GET["sign-in"])) {

  extract($_POST);

  if($user === "" || $pwd === "")
    exit("Please fill in every field.");

  $query = $db->query("SELECT * FROM users WHERE username = '$user' OR email = '$user';");
  $query = $query->fetch();

  if(!$query)
    exit("No account with this username or email address.");

  if(!password_verify($pwd, $query["pwd"]))
    exit("Wrong password.");

  $_SESSION["connected"] = true;
  $_SESSION["userID"] = $query["id"];
  $_SESSION["is_admin"] = ($query["is_admin"] == 1) ? true : false;

  header("Location: ./?profile");
  exit;

}

if(isset($_GET["sign-out"])) {
  
  session_unset();
  session_destroy();

  header("Location: ./?home");
  exit;
}