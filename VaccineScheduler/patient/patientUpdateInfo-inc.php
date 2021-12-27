<?php
  session_start();
  if (isset($_POST['submit'])) {

    require '../includes/database.php';

    $userName = $_SESSION['username'];
    $password = $_SESSION['password'];
    $permissionType = $_SESSION['permissionType'];

    $fName = $_POST['fName'];
    $mi = $_POST['mi'];
    $lName = $_POST['lName'];



    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $phoneNumber = $_POST['phoneNumber'];
    $address = $_POST['address'];
    $occupation = $_POST['occupation'];
    $SSN = $_POST['SSN'];


    $usernameToChange = $_POST['username'];
    $passwordToChange = $_POST['password'];



    /*Check for Info Provided*/
    /*Validate that the user is entering first, last names that only have letters*/
    if ((!ctype_alpha($fName) && !empty($fName)) || (!ctype_alpha($lName) && !empty($lName)) || (!ctype_alpha($mi) && !empty($mi)) ) {
      echo "<script>
      alert('Name must contain only letters.');
      window.location.href='patientUpdateInfo.php';
      </script>";
    }
    /*Validate that the user has only entered only one character for the gender*/
    else if (!empty($gender)) {
      if ((strcasecmp($gender, "F") !== 0) && (strcasecmp($gender, "M") !== 0)) {
          echo "<script>
          alert('Gender must be F or M.');
          window.location.href='patientUpdateInfo.php';
          </script>";
      }
    }
    /*Validate that the user has enterd a number for that age*/
    else if (ctype_alpha($age)) {
      echo "<script>
      alert('Age must be an integer.');
      window.location.href='patientUpdateInfo.php';
      </script>";
    }
    /*Validate that the user has entered a SSN of length 9*/
    else if (!empty($SSN) && strlen($SSN) != 9) {
      echo "<script>
      alert('SSN should only be 9 characters.');
      window.location.href='patientUpdateInfo.php';
      </script>";
    }
    /*Validate that there is no patient that already has the SSN entered*/
    else if (!empty($SSN) && ($conn->query( "SELECT * FROM Patient where ssn = '".$SSN."'")->num_rows !== 0)) {
      echo "<script>
      alert('Patient with that SSN already exists');
      window.location.href='patientUpdateInfo.php';
      </script>";
    }
    /*Validate that the user phone is in the form 773-111-1111*/
    else if (!empty($phoneNumber) && !preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phoneNumber)) {
      echo "<script>
      alert('Enter phone number in the form 773-111-1111');
      window.location.href='patientUpdateInfo.php';
      </script>";
    }

    /*Get the patients id number using the userName and password*/
    $sql = "SELECT * FROM Login,Patient
            WHERE idPermissionPatient = patientId and
                  userName = '".$userName."' and
                  userPassword = '".$password."' and
                  permissionType = '".$permissionType."' ";
    
    $result = $conn->query($sql);
    $row = mysqli_fetch_array($result);
    $patientId = $row['patientId'];
    $userId = $row['userId'];



    /*If Fname is not empty then update it*/
    if (!empty($fName)) {
      $sql = "UPDATE Patient
              SET fName = '".$fName."'
              WHERE patientId = '".$patientId."' ";
      if ($conn->query($sql) !== TRUE) {
        echo "<script>
        alert('There was an error updating First Name.');
        window.location.href='patientUpdateInfo.php';
        </script>";
      }
    }
    
    
    /*If Lname is not empty then update it*/
    if (!empty($lName)) {
      $sql = "UPDATE Patient
              SET lName = '".$lName."'
              WHERE patientId = '".$patientId."' ";
      if ($conn->query($sql) !== TRUE) {
        echo "<script>
        alert('There was an error updating Last Name.');
        window.location.href='patientUpdateInfo.php';
        </script>";
      }
    }
    
    
    /*If middle inital is not empty then update it*/
    if (!empty($mi)) {
      $sql = "UPDATE Patient
              SET mi = '".$mi."'
              WHERE patientId = '".$patientId."' ";
      if ($conn->query($sql) !== TRUE) {
        echo "<script>
        alert('There was an error updating Middle Inital.');
        window.location.href='patientUpdateInfo.php';
        </script>";
      }
    }
    
    
    
    /*If age is not empty then update it*/
    if (!empty($age)) {
      $sql = "UPDATE Patient
              SET age = '".$age."'
              WHERE patientId = '".$patientId."' ";
      if ($conn->query($sql) !== TRUE) {
        echo "<script>
        alert('There was an error updating age.');
        window.location.href='patientUpdateInfo.php';
        </script>";
      }
    }
    
    
    /*If gender is not empty then update it*/
    if (!empty($gender)) {
      $sql = "UPDATE Patient
              SET gender = '".$gender."'
              WHERE patientId = '".$patientId."' ";
      if ($conn->query($sql) !== TRUE) {
        echo "<script>
        alert('There was an error updating gender.');
        window.location.href='patientUpdateInfo.php';
        </script>";
      }
    }
    
    
    /*If phoneNumber is not empty then update it*/
    if (!empty($phoneNumber)) {
      $sql = "UPDATE Patient
              SET phoneNumber = '".$phoneNumber."'
              WHERE patientId = '".$patientId."' ";
      if ($conn->query($sql) !== TRUE) {
        echo "<script>
        alert('There was an error updating Phone Number.');
        window.location.href='patientUpdateInfo.php';
        </script>";
      }
    }
    
    
    
    /*If Address is not empty then update it*/
    if (!empty($address)) {
      $sql = "UPDATE Patient
              SET address = '".$address."'
              WHERE patientId = '".$patientId."' ";
      if ($conn->query($sql) !== TRUE) {
        echo "<script>
        alert('There was an error updating Address.');
        window.location.href='patientUpdateInfo.php';
        </script>";
      }
    }
    
    
    /*If Occupation is not empty then update it*/
    if (!empty($occupation)) {
      $sql = "UPDATE Patient
              SET occupation = '".$occupation."'
              WHERE patientId = '".$patientId."' ";
      if ($conn->query($sql) !== TRUE) {
        echo "<script>
        alert('There was an error updating occupation.');
        window.location.href='patientUpdateInfo.php';
        </script>";
      }
    }
        
    /*If SSN is not empty then update it*/
    if (!empty($SSN)) {
      $sql = "UPDATE Patient
              SET ssn = '".$SSN."'
              WHERE patientId = '".$patientId."' ";
      if ($conn->query($sql) !== TRUE) {
        echo "<script>
        alert('There was an error updating SSN.');
        window.location.href='patientUpdateInfo.php';
        </script>";
      }
    }

    if(!empty($passwordToChange)) {
      $sql = "UPDATE Login
      SET userPassword = '".$passwordToChange."'
      WHERE userId = '".$userId."' ";
       if ($conn->query($sql) !== TRUE) {
        echo "<script>
        alert('There was an error updating SSN.');
        window.location.href='patientUpdateInfo.php';
        </script>";
      }
      $_SESSION['password'] = $passwordToChange;
    }


    if(!empty($usernameToChange)) {
      $sql = "SELECT * FROM Login where userName = '".$usernameToChange."'";
      $result = $conn->query($sql);
      /*Check if the user name is already taken if not then add of the fields are valid*/
      if ($result->num_rows !== 0) {
        echo "<script>
        alert('User name taken please try another username.');
        window.location.href='patientUpdateInfo.php';
        </script>";
      } else {
        $sql = "UPDATE Login
        SET userName = '".$usernameToChange."'
        WHERE userId = '".$userId."' ";
        if ($conn->query($sql) !== TRUE) {
          echo "<script>
          alert('There was an error updating SSN.');
          window.location.href='patientUpdateInfo.php';
          </script>";
        }
        $_SESSION['username'] = $usernameToChange;
      }
    }

    echo "<script>
        alert('Updated!');
        window.location.href='patientUpdateInfo.php';
        </script>";

  }
?>