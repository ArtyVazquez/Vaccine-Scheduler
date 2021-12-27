<?php
session_start();
if (isset($_POST['submit'])) {
      require '../includes/database.php';

      $userName = $_SESSION['username'];
      $password = $_SESSION['password'];
      $permissionType = $_SESSION['permissionType'];
      $vaccineId = $_POST['vaccineId'];
      $patientId = $_POST['patientId'];
      $doseNumber = $_POST['doseNumber'];
      $timeSlot = $_POST['timeSlot'];

      /*Get total number of doses patient has taken so far*/
      $sql = "SELECT numberOfDoses FROM VaccinationRecord 
            WHERE patientId = '".$patientId."' ";
      $result = $conn->query($sql);
      $dosesTaken = 0;
      $vaccineGiven = "";
      while($row = mysqli_fetch_array($result)) { 
        $dosesTaken += $row['numberOfDoses'];
      }
      $doseNumber += $dosesTaken;
      /*Get the nurseId*/
      $sql = "SELECT nurseId FROM Login,Nurse
              WHERE idPermissionNurse = nurseId and
                    userName = '".$userName."' and
                    userPassword = '".$password."' and
                    permissionType = '".$permissionType."' ";

      $result = $conn->query($sql);
      $row = mysqli_fetch_array($result);
      $nurseID = $row['nurseId'];
        /*Add to the Vaccination Record table*/
        $sql = "INSERT INTO VaccinationRecord(vaccineId, patientId, nurseId, numberOfDoses, timeSlot)
        VALUES('".$vaccineId."', '".$patientId."', '".$nurseID."', '".$doseNumber."', '".$timeSlot."')";
        /*Check if query was successful.*/
        if ($conn->query($sql) !== TRUE) {
          echo "<script>
          alert('There was an error please try again.');
          window.location.href='../nurse.php';
          </script>";
        } else {
            /*Query was successful now update the onhold and remove one*/
            $sql = "UPDATE Vaccine
                  SET onHold = onHold - 1, availability = availability - 1
                  WHERE vaccineId = '".$vaccineId."' ";
            if ($conn->query($sql) === TRUE) {
              echo "<script>
              alert('Successful.');
              window.location.href='../nurse.php';
              </script>";
            } else {
              echo "<script>
              alert('There was an error please try again.');
              window.location.href='../nurse.php';
              </script>";
              }
          }
      $conn->close();
  }
 ?>