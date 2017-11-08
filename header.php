<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login System</title>
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
<header class="main-header">
  <nav class="main-nav">
    <div class="wrapper">
      <ul class="main-nav__list">
        <li class="main-nav__item">
          <a class="main-nav__link" href="index.php">Home</a>
        </li>
      </ul>
      <div class="login">
        <?php
          if(isset($_SESSION['u_id'])){

           echo ' <form action="includes/logout.inc.php" method="post" class="login__form">
          <button type="submit" name="submit">Logout</button>
        </form>';

          } else {
            echo '
            <form action="includes/login.inc.php" class="login__form" method="post">
              <input type="text" name="uid" placeholder="Username/e-email">
              <input type="password" name="pwd" placeholder="password">
              <button type="submit" name="submit">Login</button>
            </form>
            <a href="signup.php" class="signup-link">Sign Up</a>
        ';
          }
        ?>


      </div>
    </div>
  </nav>
</header>