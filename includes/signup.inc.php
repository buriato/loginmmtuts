<?php
ini_set("display_errors","On");
if (isset($_POST['submit'])){
  include_once 'dbh.inc.php';
  $first = mysqli_real_escape_string($conn, $_POST['first']);
  $last = mysqli_real_escape_string($conn, $_POST['last']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);

  // Error handlers
  // Check for empty fields
  if (empty($first) || empty($last) || empty($email) || empty($uid) || empty(pwd)){
    header("Location: ../signup.php?signup=empty");
    exit();
  } else {
    // Check if input characters are valid
    if (!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$/", $last)) {
      header("Location: ../signup.php?signup=invalid");
      exit();
    } else {
      // Check if email is valid
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        header("Location: ../signup.php?signup=email");
        exit();
      } else {
        //Created a template whith placeholder ?
        $sql = "SELECT * FROM  users WHERE user_uid=?;";
        // Create a prepared statement
        $stmt = mysqli_stmt_init($conn);
        // prepare statement
        if(!mysqli_stmt_prepare($stmt, $sql)){
          header("Location: ../signup.php?signup=error");
          exit();
        } else {
          //bind parameters to the placeholder
          mysqli_stmt_bind_param($stmt, "s", $uid);
          //run parameters inside database
          mysqli_stmt_execute($stmt);
          // store result
          mysqli_stmt_store_result($stmt);
          $resultCheck = mysqli_stmt_num_rows($stmt);
          if ($resultCheck > 0){
            header("Location: ../signup.php?signup=usertaken");
            exit();
          } else {
            //Hashing the password
            $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
            //Insert the user into the database
            $sql = "INSERT INTO users (user_first, user_last, user_email, user_uid, user_pwd) VALUES (?,?, ?, ?, ?);";
            $stmt2 = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt2, $sql)){
              header("Location: ../signup.php?signup=error");
              exit();
            } else {
              mysqli_stmt_bind_param($stmt2, "sssss", $first,$last, $email, $uid, $hashedPwd);
              mysqli_stmt_execute($stmt2);
              header("Location: ../signup.php?signup=success");
              exit();
            }
          }
        }
      }
    }
  }
  // Close first statement
  mysqli_stmt_close($stmt);
  // Close second statement
  mysqli_stmt_close($stmt2);
} else {
  header("Location: ../signup.php");
  exit();
}