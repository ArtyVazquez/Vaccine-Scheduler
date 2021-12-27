<?php
  session_start();
  if (isset($_POST['submit'])) {
    //ADD database connection
    require 'database.php';
    $nurseUserName = $_POST['nurseUserName'];
    $nurseFname = $_POST['nurseFname'];
    $nurseLname = $_POST['nurseLname'];
    $fName = $_POST['fName'];
    $mi = $_POST['mi'];
    $lName = $_POST['lName'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $username = $_POST['username'];
    $passwordToChange = $_POST['password'];

    /*Alter the user if there are any required input fields that need are not filled*/
    if (empty($nurseUserName) || empty($nurseFname) || empty($nurseLname)) {
      echo "<script>
      alert('Please enter all of the following nurse username, first name, and last name');
      window.location.href='../admin/updateNurse.php';
      </script>";
    } 
    
    else {
      /*Validate that the user is entering first, last names that only have letters*/
      if ((!empty($fName) && !ctype_alpha($fName))|| (!empty($lName) && !ctype_alpha($lName))) {
        echo "<script>
        alert('Name must contain only letters.');
        window.location.href='../admin/updateNurse.php';
        </script>";
      } 
      /*Validate that the user has only entered only one character for the gender*/
      else if (!empty($gender) && (!ctype_alpha($gender) || strlen($gender) != 1)) {
        echo "<script>
        alert('Gender must contain only one letter.');
        window.location.href='../admin/updateNurse.php';
        </script>";
      } 
      /*Validate that the user has enterd a number for that age*/
      else if (!empty($gender) && ctype_alpha($age)) { 
        echo "<script>
        alert('Age must be an integer.');
        window.location.href='../admin/updateNurse.php';
        </script>";
      } 
  
      else {
        /*Query to get table with the same user name. If already exists display an error to the user*/
        $sql = "SELECT * FROM Login,Nurse where 
                                                Login.idPermissionNurse = Nurse.nurseId and 
                                                Login.userName = '".$nurseUserName."' and 
                                                Nurse.fName = '".$nurseFname."' and
                                                Nurse.lName = '".$nurseLname."' ";
        $result = $conn->query($sql);
         /*Check if the user name is already taken if not then add of the fields are valid*/
        if ($result->num_rows < 1) {
          echo "<script>
          alert('Nurse does not exist please verify nurse username, first name, and last name');
          window.location.href='../admin/updateNurse.php';
          </script>";
        } else  {
            /*Queries to updatenurse*/
            $row = mysqli_fetch_array($result);
            $nurseID = $row['nurseId']; 
            $userID = $row['userId']; 

            if (!empty($fName)) {
              $sql = "UPDATE Nurse
              SET fName = '".$fName."'
              WHERE nurseId = '".$nurseID."'";
              if ($conn->query($sql) !== TRUE) {
                echo "<script>
                alert('There was an error updating first name initial.');
                window.location.href='../admin/updateNurse.php';
                </script>";
              }
            }
             
            if (!empty($mi)) {
              $sql = "UPDATE Nurse
              SET mi = '".$mi."'
              WHERE nurseId = '".$nurseID."'";
              if ($conn->query($sql) !== TRUE) {
                echo "<script>
                alert('There was an error updating middle initial.');
                window.location.href='../admin/updateNurse.php';
                </script>";
              }
            } 
            if (!empty($lName)) {
              $sql = "UPDATE Nurse
              SET lName = '".$lName."'
              WHERE nurseId = '".$nurseID."'";
              if ($conn->query($sql) !== TRUE) {
                echo "<script>
                alert('There was an error updating last name.');
                window.location.href='../admin/updateNurse.php';
                </script>";
              }
            }
            
            if (!empty($gender)) {
              $sql = "UPDATE Nurse
              SET gender = '".$gender."'
              WHERE nurseId = '".$nurseID."'";
              if ($conn->query($sql) !== TRUE) {
                echo "<script>
                alert('There was an error updating gender.');
                window.location.href='../admin/updateNurse.php';
                </script>";
              }
            }
            if (!empty($age)) {
              $sql = "UPDATE Nurse
              SET age = '".$age."'
              WHERE nurseId = '".$nurseID."'";
              if ($conn->query($sql) !== TRUE) {
                echo "<script>
                alert('There was an error updating age.');
                window.location.href='../admin/updateNurse.php';
                </script>";
              }
            }
            
            
            if (!empty($username)) {
              $sql = "SELECT * FROM Login where userName = '".$username."'";
              $result = $conn->query($sql);
              /*Check if the user name is already taken*/
              if ($result->num_rows !== 0) {
                echo "<script>
                alert('User name taken please try another username.');
                window.location.href='../admin/updateNurse.php';
                </script>";
              } else {
                $sql = "UPDATE Login
                SET userName = '".$username."'
                WHERE userId = '".$userID."'";
                $conn->query($sql);
              }
            } 


            if(!empty($passwordToChange)) {
              $sql = "UPDATE Login
              SET userPassword = '".$passwordToChange."'
              WHERE userId = '".$userID."' ";
              if ($conn->query($sql) !== TRUE) {
                echo "<script>
                alert('There was an error updating Password');
                window.location.href='../admin/updateNurse.php';
                </script>";
              }
            }
            echo "<script>
                alert('Successful update.');
                window.location.href='../admin.php';
                </script>";
          }
        }
      }
      $conn->close();
    }
 ?>