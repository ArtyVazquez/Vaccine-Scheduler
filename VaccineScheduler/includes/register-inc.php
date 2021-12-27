<?php

  if (isset($_POST['submit'])) {
    require 'database.php';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPass = $_POST['confirmPassword'];
    $fName = $_POST['fName'];
    $mi = $_POST['mi'];
    $lName = $_POST['lName'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $occupation = $_POST['occupation'];
    $phoneNumber = $_POST['phoneNumber'];
    $ssn = $_POST['ssn'];
    $address = $_POST['address'];


    /*Alter the user if there are any required input fields that need are not filled*/
    if (empty($username) || empty($password) || empty($confirmPass) || empty($fName) || empty($address) ||
        empty($lName) || empty($gender) || empty($age) || empty($phoneNumber) || empty($ssn)) {
      echo "<script>
      alert('Enter all requires fields to create account.');
      window.location.href='../register.php';
      </script>";
    }

    else {

      /*Validate that the user is entering first, last names that only have letters*/
      if (!ctype_alpha($fName) || !ctype_alpha($lName)) {
        echo "<script>
        alert('Name must contain only letters.');
        window.location.href='../register.php';
        </script>";
      }
      /*Validate that mi that only have letters or is null*/
      else if (!empty($mi) && !(ctype_alpha($mi))) {
        echo "<script>
        alert('middle inital must be only letters');
        window.location.href='../register.php';
        </script>";
      }
      /*Validate that the user has only entered only one character for the gender*/
      else if ((strcasecmp($gender, "F") !== 0) && (strcasecmp($gender, "M")!== 0)) {
        echo "<script>
        alert('Gender must contain only one letter.');
        window.location.href='../register.php';
        </script>";
      }
      /*Validate that the user has enterd a number for that age*/
      else if (ctype_alpha($age)) {
        echo "<script>
        alert('Age must be an integer.');
        window.location.href='../register.php';
        </script>";
      }
      /*Validate that the user has entered a SSN of length 9*/
      else if (strlen($ssn) != 9) {
        echo "<script>
        alert('SSN should only be 9 characters.');
        window.location.href='../register.php';
        </script>";
      }
      /*Validate that there is no patient that already has the SSN entered*/
      else if ( ($conn->query( "SELECT * FROM Patient where ssn = '".$ssn."'")->num_rows !== 0)) {
        echo "<script>
        alert('Patient with that SSN already exists');
        window.location.href='../register.php';
        </script>";
      }
      /*Validiate that the user password matches the confirm password*/
      else if ($password !== $confirmPass) {
        echo "<script>
        alert('Passwords don't match.');
        window.location.href='../register.php';
        </script>";
      }
      /*Validate that the user phone is in the form 773-111-1111*/
      else if (!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phoneNumber)) {
        echo "<script>
        alert('Enter phone number in the form 773-111-1111');
        window.location.href='../register.php';
        </script>";
      }

      else {
        echo"<p>HERE</p>";
        /*Query to get table with the same user name. If already exists display an error to the user*/
        $sql = "SELECT * FROM Login where userName = '".$username."'";
        $result = $conn->query($sql);
        echo"<p>HERE2</p>";
         /*Check if the user name is already taken if not then add of the fields are valid*/
        if ($result->num_rows !==0) {
          echo "<script>
          alert('User name taken please try another username.');
          window.location.href='../register.php';
          </script>";
        } else  {
            /*Query to insert patient into the database*/
            $sql = "INSERT INTO Login (userName, userPassword, permissionType)
            VALUES ('".$username."', '".$password."', 'P')";
            /*Patient successfully created his login. Now insert the paient into the patient table*/
            if ($conn->query($sql) === TRUE) {
              /* Add the FK from login to patient */
              $last_id = mysqli_insert_id($conn);
              $sql = "INSERT INTO Patient (ssn, fName, mi, lName, age, gender, phoneNumber, address, occupation, userId)
              VALUES ('".$ssn."' ,'".$fName."' ,'".$mi."' ,'".$lName."' ,'".$age."' ,'".$gender."', '".$phoneNumber."',
              '".$address."' ,'".$occupation."' ,'".$last_id."')";
              /* Add the FK from patient to Login */
              if($conn->query($sql) === TRUE) {
                $last_id = mysqli_insert_id($conn);
                echo $last_id ;
                $sql = "UPDATE Login
                        SET idPermissionPatient = '".$last_id."'
                        WHERE userName = '".$username."'";
                $conn->query($sql);
                echo "New record created successfully";
                echo "<script>
                alert('Success. You can now login!');
                window.location.href='../login.php';
                </script>";

              }  else {
                echo "<script>
                alert('Something went wrong please try again');
                window.location.href='../login.php';
                </script>";
              }
            }
          }
        }
      }
    }
    $conn->close();
 ?>