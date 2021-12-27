<?php
  session_start();
  if (isset($_POST['submit'])) {
    require 'database.php';
    
    $sql = "SELECT * FROM LOGIN";
    $result = $conn->query($sql);
  

    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPass = $_POST['confirmPassword'];
    $fName = $_POST['fName'];
    $mi = $_POST['mi'];
    $lName = $_POST['lName'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $phoneNumber = $_POST['phoneNumber'];
    $address = $_POST['address'];


    /*Alter the user if there are any required input fields that need are not filled*/
    if (empty($username) || empty($password) || empty($confirmPass) || empty($fName) || empty($address) ||
        empty($lName) || empty($gender) || empty($age) || empty($phoneNumber)) {
      echo "<script>
      alert('Enter all requires fields to create account.');
      window.location.href='../admin/adminregisterNurse.php';
      </script>";
    } else if (!ctype_alpha($fName) || !ctype_alpha($lName)) {
        echo "<script>
        alert('Name must contain only letters.');
        window.location.href='../admin/adminregisterNurse.php';
        </script>";
      } 
      /*Validate that mi that only have letters or is null*/
      else if (!empty($mi) && !(ctype_alpha($mi) )) {
        echo "<script>
        alert('Middle inital must contain a letter');
        window.location.href='../admin/adminregisterNurse.php';
        </script>";
      }
      /*Validate that the user has only entered only one character for the gender*/
      else if ((strcasecmp($gender, "F") !== 0) && (strcasecmp($gender, "M") !== 0)) {
            echo "<script>
            alert('Gender must be F or M.');
            window.location.href='../admin/adminregisterNurse.php';
            </script>";
        
      }
      /*Validate that the user has enterd a number for that age*/
      else if (ctype_alpha($age)) { 
        echo "<script>
        alert('Age must be an integer.');
        window.location.href='../admin/adminregisterNurse.php';
        </script>";
      } 
      /*Validiate that the user password matches the confirm password*/
      else if ($password !== $confirmPass) {
        echo "<script>
        alert('Passwords don't match.');
        window.location.href='../admin/adminregisterNurse.php';
        </script>";
      } 
      /*Validate that the user phone is in the form 773-111-1111*/
      else if (!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phoneNumber)) {
        echo "<script>
        alert('Enter phone number in the form 773-111-1111');
        window.location.href='../admin/adminregisterNurse.php';
        </script>";
      }
      
      else {
        /*Query to get table with the same user name. If already exists display an error to the user*/
        $sql = "SELECT * FROM Login where userName = '".$username."' ";
        $result = $conn->query($sql);

        
        
         /*Check if the user name is already taken if not then add of the fields are valid*/
        if ($result->num_rows !== 0) {
          echo "<script>
          alert('User name taken please try another username.');
          window.location.href='../admin/adminregisterNurse.php';
          </script>";
        } else  {
            /*Query to insert nurse into the database. Login table*/
            $sql = "INSERT INTO Login (userName, userPassword, permissionType)
            VALUES ('".$username."', '".$password."', 'N')";
            /*Nurse login was created. Now insert the nurse into the nurse table*/
            if ($conn->query($sql) === TRUE) {
              /* Add the FK from login to nurse */
              $last_id = mysqli_insert_id($conn);
              $sql = "INSERT INTO Nurse(fName, mi, lName, age, gender, phoneNumber, address, userId)
              VALUES ('".$fName."' ,'".$mi."' ,'".$lName."' ,'".$age."' ,'".$gender."', '".$phoneNumber."', 
              '".$address."', '".$last_id."')";
              /* Add the FK from nurse to Login */
              if($conn->query($sql) === TRUE) {
                $last_id = mysqli_insert_id($conn);
                echo $last_id ;
                $sql = "UPDATE Login 
                        SET idPermissionNurse = '".$last_id."'
                        WHERE userName = '".$username."'";
                $conn->query($sql);
                echo "<script>
                alert('Success. Nurse can now login!');
                window.location.href='../admin.php';
                </script>";

              }  else {
                echo "<script>
                alert('Something went wrong please try again');
                window.location.href='../admin/adminregisterNurse.php';
                </script>";
              }
            } else {
              echo "<script>
              alert('Something went wrong please try again');
              window.location.href='../admin/adminregisterNurse.php';
              </script>";
            }
          }
        }
      $conn->close();
    }
 ?>