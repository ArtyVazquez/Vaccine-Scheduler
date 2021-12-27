<?php
  session_start();
  if (isset($_POST['submit'])) {
    require '../includes/database.php';
    
    $userName = $_SESSION['username'];
    $password = $_SESSION['password'];
    $permissionType = $_SESSION['permissionType'];
    $vaccineId = $_SESSION['vaccineId'];
    $timeSlot = $_POST['timeSlot'];

    /*Patient Id*/
    $sql = "SELECT * FROM Login,Patient
            WHERE idPermissionPatient = patientId and
                  userName = '".$userName."' and
                  userPassword = '".$password."' and
                  permissionType = '".$permissionType."' ";
    $result = $conn->query($sql);
    $row = mysqli_fetch_array($result);
    $patientId = $row['patientId'];

    /*Get time Slot id*/
    $sql = "SELECT * FROM TimeSlot where 
              timeSlot = '".$timeSlot."'";
    $result = $conn->query($sql);
    $row = mysqli_fetch_array($result);
    $timeSlotId = $row['timeSlotId'];


    $sql = "SELECT * FROM VaccinationRecord 
            WHERE patientId = '".$patientId."' ";
    $result = $conn->query($sql);
    $dosesTaken = 0;
    $vaccineGiven = "";
    while($row = mysqli_fetch_array($result)) { 
      $vaccineGiven = $row['vaccineId'];
      $dosesTaken += $row['numberOfDoses'];
    }    
    /*Vaccination record does not exist so make the schedule without verifying anything*/
    if($result->num_rows === 0) {
      $sql = "INSERT INTO VaccinationSchedule(patientId, timeSlotId, vaccineId)
              VALUES('".$patientId."','".$timeSlotId."', '".$vaccineId."')";
      if($conn->query($sql) === TRUE) {
        /*SET ON HOLD*/
        $sql = "UPDATE Vaccine 
                SET onHold = onHold + 1
                WHERE vaccineId = '".$vaccineId."'";
        $conn->query($sql);
        /*Timeslot table set available slot -1*/
        $sql = "UPDATE TimeSlot 
                SET availableSlots = availableSlots -1
                WHERE timeSlotId = '".$timeSlotId."'";
        $conn->query($sql);
        echo "<script>
        alert('Successul.');
        window.location.href='patientScheduleVaccination.php';
        </script>";
      } else {
        echo "<script>
        alert('An error occured please try again');
        window.location.href='patientScheduleVaccination.php';
        </script>";
      }
    } else {
      /*Check the total number of doses for immunization if the patient exceeds that number
      give an error*/
      $sql = "SELECT * FROM Vaccine 
            WHERE vaccineId = '".$vaccineId."'";
      $result = $conn->query($sql);
      $row = mysqli_fetch_array($result);
      $numDosesForImm = $row['numberDosesImm'];

      /*Vaccine already taken does not match the same type patient is scheduling*/
      if ($vaccineGiven != $vaccineId) {
        echo "<script>
        alert('You have taken a vaccine of some other type. Schedule an appointment of the same type.');
        window.location.href='patientScheduleVaccination.php';
        </script>";
      } else if ($dosesTaken >= $numDosesForImm ) {
        echo "<script>
        alert('You have already taken the number doses for immunization.');
        window.location.href='patientScheduleVaccination.php';
        </script>";
      } else {
          /*Create the appointment*/
          $sql = "INSERT INTO VaccinationSchedule(patientId, timeSlotId, vaccineId)
                VALUES('".$patientId."','".$timeSlotId."', '".$vaccineId."')";
          if($conn->query($sql) === TRUE) {
                  /*SET ON HOLD*/
            $sql = "UPDATE Vaccine 
            SET onHold = onHold + 1
            WHERE vaccineId = '".$vaccineId."'";
            $conn->query($sql);
            /*Timeslot table set available slot -1*/
            $sql = "UPDATE TimeSlot 
                    SET availableSlots = availableSlots -1
                    WHERE timeSlotId = '".$timeSlotId."'";
            $conn->query($sql);
              echo "<script>
              alert('Successul.');
              window.location.href='patientScheduleVaccination.php';
              </script>";
            } else {
              echo "<script>
              alert('An error occured please try again.');
              window.location.href='patientScheduleVaccination.php';
              </script>";
            }
        }
    }
  }
?>