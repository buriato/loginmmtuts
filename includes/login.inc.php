<?php

session_start();

if(isset($_POST['submit'])){
  include "dbh.inc.php";
  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);

  // Error handlers
  // Check if inputs are empty

  if (empty($uid) || empty($pwd)){
    header("Location: ../index.php?login=empty");
    exit();
  } else {
    $sql = "SELECT * FROM  users WHERE user_uid = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
      header("Location: ../index.php?login=error");
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "s", $uid);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if($row = mysqli_fetch_assoc($result)){
        // De-hashing the password
        $hashedPwdCheck = password_verify($pwd,$row['user_pwd']);
        if ($hashedPwdCheck ==false){
          header("Location: ../index.php?login=error");
          exit();
        } elseif ($hashedPwdCheck == true){
          // Log in the user here
          $_SESSION['u_id'] = $row['user_id'];
          $_SESSION['u_first'] = $row['user_first'];
          $_SESSION['u_last'] = $row['user_last'];
          $_SESSION['u_email'] = $row['user_email'];
          $_SESSION['u_uid'] = $row['user_uid'];
          header("Location: ../index.php?login=success");
          exit();
        }
      } else {
        header("Location: ../index.php?login=error");
        exit();
      }
    }
  }
  mysqli_stmt_close($stmt);
} else {
  header("Location: ../index.php?login=error");
  exit();
}