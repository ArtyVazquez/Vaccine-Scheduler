<?php
  session_start();
   
  function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);
    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
  }

  if (isset($_POST['submit'])) {
    //ADD database connection
    require 'database.php';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $permissionType = $_POST['permissionType'];

    /*There was empty inputs redirect the user to the login page again*/
    if (empty($username) || empty($password) || empty($permissionType)) {
      echo "<script>
                  alert('Empty fields');
                  window.location.href='../login.php';
                  </script>";
    } 
    /*No empty input fields.. Query the info given by the user*/
    else {
      $sql = "SELECT permissionType FROM Login where userName = '".$username."' and userPassword = '".$password."'";
      $result = $conn->query($sql);
      if ($result->num_rows !== 0) {
          $row = mysqli_fetch_array($result);
        /*User found redirect to admin page */
        if ($row["permissionType"] === 'A' && ($permissionType === 'a' || $permissionType === 'A')) {
          $_SESSION['username'] = $_POST['username'];
          $_SESSION['password'] = $_POST['password'];
          $_SESSION['permissionType'] = $_POST['permissionType'];
          header("Location: ../admin.php");
        } 
        /*User found redirect to patient page */
        else if ($row["permissionType"] === 'P' && ($permissionType === 'p' || $permissionType === 'P') ) {
          $_SESSION['username'] = $_POST['username'];
          $_SESSION['password'] = $_POST['password'];
          $_SESSION['permissionType'] = $_POST['permissionType'];
          header("Location: ../patient.php");
        } 
        /*User found redirect to nurse page */
        else if ($row["permissionType"] === 'N' && ($permissionType === 'n' || $permissionType === 'N')) {
          $_SESSION['username'] = $_POST['username'];
          $_SESSION['password'] = $_POST['password'];
          $_SESSION['permissionType'] = $_POST['permissionType'];
          header("Location: ../nurse.php");
        } 
        /*User found but they eneterd wrong */
        else {
          echo "<script>
                  alert('No permission type match.');
                  window.location.href='../login.php';
                  </script>";
        }
      } 
      /*No user found redirect them to the login page again*/
      else {
        echo "<script>
                  alert('Wrong username or password.');
                  window.location.href='../login.php';
                  </script>";
       }
     }
  }
?>