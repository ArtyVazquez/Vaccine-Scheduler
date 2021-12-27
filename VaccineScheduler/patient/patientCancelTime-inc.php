<?php
session_start();
if (isset($_POST['submit'])) {
    require '../includes/database.php';
    
    $userName = $_SESSION['username'];
    $password = $_SESSION['password'];
    $permissionType = $_SESSION['permissionType'];
    $date = date("m-d-Y", strtotime($_POST['date']));
    $time = date('h:i A', strtotime($_POST['time']));

    $newTimeSlot = $date . " ". $time;

    /*Check if the time slot is available*/
    $sql = "SELECT * FROM TimeSlot where 
    timeSlot = '".$newTimeSlot."'";
    $result = $conn->query($sql);

    /*If row not 0 time slot exists*/
    if ($result->num_rows === 0) {
      echo "<script>
      alert('Time does not exist please try another time.');
      window.location.href='patientCancelTime.php';
      </script>";
    } 
      /*GET PATIENT ID*/
      /*Query. TO obtain the patientId*/
      $row = mysqli_fetch_array($result);
      $timeSlotId = $row['timeSlotId'];

      $sql = "SELECT * FROM Login,Patient where 
      Login.idPermissionPatient = patientId and 
      Login.userName = '".$userName."' and 
      Login.permissionType = '".$permissionType."'";
      $result = $conn->query($sql);
      if ($result->num_rows === 0) {
        echo "<script>
        alert('There was an error please try again');
        window.location.href='patientCancelTime.php';
        </script>";
      }

      $result = $conn->query($sql);
      $row = mysqli_fetch_array($result);
      $patientId = $row['patientId'];
        
      $sql = "SELECT * FROM VaccinationSchedule
              WHERE patientId = '".$patientId."' AND
              timeSlotId = '".$timeSlotId."'";
      $result = $conn->query($sql);
      if ($result->num_rows === 0) {
        echo "<script>
        alert('There was an error please try again');
        window.location.href='patientCancelTime.php';
        </script>";
      } 
      $row = mysqli_fetch_array($result);
      $vaccineId = $row['vaccineId'];
      $scheduleId = $row['scheduleId'];

      $sql = "UPDATE TimeSlot SET
              availableSlots = availableSlots + 1
              WHERE 
              timeSlotId = '".$timeSlotId."'";
      $result = $conn->query($sql);
      if ($result->num_rows === 0) {
        echo "<script>
        alert('There was an error please try again');
        window.location.href='patientCancelTime.php';
        </script>";
      } 
      $sql = "UPDATE Vaccine 
      SET onHold = onHold - 1
      WHERE vaccineId = '".$vaccineId."'";
      $conn->query($sql);

      /*delete the vaccinationSchedule*/
      $sql = "DELETE FROM VaccinationSchedule WHERE
      scheduleId = '".$scheduleId."'";
      $conn->query($sql);

      echo "<script>
      alert('Success.');
      window.location.href='../patient.php';
      </script>";
 }         
?>