<?php
session_start();
if (isset($_POST['submit'])) {
      //ADD database connection
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
          window.location.href='nurseScheduleTime.php';
          </script>";
      } else {
        /*Check if there are available nurse spots*/
        $row = mysqli_fetch_array($result);
        $numNurses = $row['numberOfNurses']; 
        $timeSlotId = $row['timeSlotId'];
        $availableSlots = $row['availableSlots'];



        if ($numNurses >= 12) {
          echo "<script>
          alert('Timeslot has maximum nurses. Try another time.');
          window.location.href='nurseScheduleTime.php';
          </script>";
        }


        /*Query. TO obtain the nurseId*/
        $sql = "SELECT * FROM Login,Nurse where 
        Login.idPermissionNurse = Nurse.nurseId and 
        Login.userName = '".$userName."' and 
        Login.permissionType = '".$permissionType."'";
        $result = $conn->query($sql);
  
        
        if ($result->num_rows === 0) {
          echo "<script>
          alert('There was an error scheduling please try again.');
          window.location.href='../nurse.php';
          </script>";
        }else {

          $result = $conn->query($sql);
          $row = mysqli_fetch_array($result);
          $nurseID = $row['nurseId'];
          

          /*If nurse already register for the same time throw error*/
          $sql = "SELECT * FROM NurseSchedule
          WHERE nurseID = '".$nurseID."' and 
                timeSlotId = '".$timeSlotId."' ";
          $result = $conn->query($sql);
          if ($result->num_rows !== 0) {
            

            echo "<script>
            alert('You already have a schedule for this time slot.');
            window.location.href='../nurse.php';
            </script>";
          } else {
                /*10 or less nurses a time slot keep each nurse to work on 10 patients*/
              if ($numNurses < 10) {
                /*Update the nurse + 1 and available lots +10 */
                $newNurseTotal = $numNurses + 1;
                $newAvailableSlots = $availableSlots + 10;
                $sql = "UPDATE TimeSlot SET
                        numberOfNurses = '".$newNurseTotal."',
                        availableSlots = '".$newAvailableSlots."'
                        WHERE 
                        timeSlot = '".$newTimeSlot."'";
                if ($conn->query($sql) !== TRUE) {
                  echo "<script>
                  alert('There was an error scheduling please try again.');
                  window.location.href='../nurse.php';
                  </script>";
                } 

              
                $sql = "INSERT INTO  NurseSchedule(nurseID, timeSlotId, numPatients)
                        VALUES ('".$nurseID."', '".$timeSlotId."', 10)";
              
                if ($conn->query($sql) !== TRUE) {
                  echo "<script>
                  alert('There was an error scheduling please try again.');
                  window.location.href='../nurse.php';
                  </script>";
                } else {
                  $last_id = mysqli_insert_id($conn);
                  $sql = "UPDATE  Nurse SET scheduleId = '".$last_id."'
                          WHERE nurseId = '".$nurseID."'";
                  $conn->query($sql);
                  echo "<script>
                  alert('Successful Schedule');
                  window.location.href='../nurse.php';
                  </script>";

                }
              }

              /*11 nurses a time slot modify the number of patients each nurse can attend*/
              if ($numNurses == 10) {
                $sql = "SELECT * FROM NurseSchedule
                        WHERE timeSlotId = '".$timeSlotId."' ";
                $result = mysqli_query($conn, $sql);
                $index = 0;
                
                while ($row = mysqli_fetch_assoc($result)) {
                  if ($index == 8) {
                    break;
                  }
                    $sql = "UPDATE NurseSchedule
                    SET numPatients = 9
                    WHERE nurseId = '".$row['nurseID']."'";
                    $conn->query($sql);
                    $index++;
                }
            

                $newNurseTotal = $numNurses + 1;
                $sql = "UPDATE TimeSlot SET
                        numberOfNurses = '".$newNurseTotal."'
                        WHERE 
                        timeSlot = '".$newTimeSlot."'";
                $conn->query($sql);
                $sql = "INSERT INTO  NurseSchedule(nurseID, timeSlotId, numPatients)
                VALUES ('".$nurseID."', '".$timeSlotId."', 8)";
                $conn->query($sql);
                $last_id = mysqli_insert_id($conn);
                $sql = "UPDATE  Nurse SET scheduleId = '".$last_id."'
                        WHERE nurseId = '".$nurseID."'";
                $conn->query($sql);

                echo "<script>
                  alert('Successful Schedule');
                  window.location.href='../nurse.php';
                  </script>";

              }

              /*12 nurses a time slot modify the number of patients each nurse can attend*/
              else if ($numNurses == 11) {
                $sql = "SELECT * FROM NurseSchedule
                        WHERE timeSlotId = '".$timeSlotId."' ";
                $result = mysqli_query($conn, $sql);
                $index = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                  if ($index == 8) {
                    break;
                  }
                    $sql = "UPDATE NurseSchedule
                    SET numPatients = 8
                    WHERE nurseId = '".$row['nurseID']."'";
                    $conn->query($sql);
                    $index++;
                }
                $newNurseTotal = $numNurses + 1;
                $sql = "UPDATE TimeSlot SET
                        numberOfNurses = '".$newNurseTotal."'
                        WHERE 
                        timeSlot = '".$newTimeSlot."'";
                $conn->query($sql);
                $sql = "INSERT INTO  NurseSchedule(nurseID, timeSlotId, numPatients)
                VALUES ('".$nurseID."', '".$timeSlotId."', 8)";
                $conn->query($sql);
                $last_id = mysqli_insert_id($conn);
                $sql = "UPDATE  Nurse SET scheduleId = '".$last_id."'
                        WHERE nurseId = '".$nurseID."'";
                $conn->query($sql);
                echo "<script>
                  alert('Successful Schedule');
                  window.location.href='../nurse.php';
                  </script>";

              }
          }
        }
      }
    $conn->close();
  }
 ?>