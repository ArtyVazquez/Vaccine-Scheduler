<?php
session_start();
if (isset($_POST['submit'])) {
      require '../includes/database.php';

      $userName = $_SESSION['username'];
      $password = $_SESSION['password'];
      $permissionType = $_SESSION['permissionType'];
      $phoneNumber = $_POST['phoneNumber'];
      $address = $_POST['address'];


      if(empty($phoneNumber) && empty($address)) {
        header("Location: nurseUpdate.php");
      }

      /*Query to get table with the same user name. If already exists display an error to the user*/
      $sql = "SELECT * FROM Login,Nurse where 
              Login.idPermissionNurse = Nurse.nurseId and 
              Login.userName = '".$userName."' and 
              Login.permissionType = '".$permissionType."'";
      $result = $conn->query($sql);
      /*Check if the user name is already taken if not then add of the fields are valid*/
      if ($result->num_rows === 0) {
        echo "<script>
        alert('There was an error updating please try again.');
        window.location.href='nurseUpdate.php';
        </script>";
      } /*Validate that the user phone is in the form 773-111-1111*/
      else if (!empty($phoneNumber) && !preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phoneNumber)) {
        echo "<script>
        alert('Enter phone number in the form 773-111-1111');
        window.location.href='nurseUpdate.php';
        </script>";
      } 
      else {
        $row = mysqli_fetch_array($result);
        $nurseID = $row['nurseId']; 
        
        if(!empty($phoneNumber)) {
          $sql = "UPDATE NURSE 
          SET phoneNumber = '".$phoneNumber."'
          WHERE nurseId = '".$nurseID."'";
        
          if($conn->query($sql) !== TRUE) {
          echo "<script>
          alert('There was an error updating please try again.');
          window.location.href='nurseUpdate.php';
          </script>";
          }  
        }

        if (!empty($address)) {
          $sql = "UPDATE NURSE 
          SET address = '".$address."'
          WHERE nurseId = '".$nurseID."'";
        
          if ($conn->query($sql) !== TRUE) {
            echo "<script>
            alert('There was an error updating please try again.');
            window.location.href='nurseUpdate.php';
            </script>";
          } 
        }
        
        echo "<script>
            alert('Successful update');
            window.location.href='../nurse.php';
            </script>";
      }
    $conn->close();
  }
 ?>