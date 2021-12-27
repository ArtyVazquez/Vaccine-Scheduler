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
          window.location.href='nurseCancelTime.php';
          </script>";
      } else {
        /*Check if there are available nurse spots*/
        $row = mysqli_fetch_array($result);
        $numNurses = $row['numberOfNurses']; 
        $timeSlotId = $row['timeSlotId'];
        $availableSlots = $row['availableSlots'];



        if ($numNurses <= 0) {
          echo "<script>
          alert('Timeslot doesn't have any nurses currently');
          window.location.href='nurseCancelTime.php';
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
          alert('There was an error please try again');
          window.location.href='nurseCancelTime.php';
          </script>";
        } else {

          /*Will only cancel a time if there are more nurses than patients otherwise will not cancel a time..*/
          
            // Get the total number of patients that nurse is attedning from that time slot
            $sql1 =  "SELECT numPatients
            FROM timeSlot, NurseSchedule
            WHERE timeSlot.timeSlotId = NurseSchedule.timeSlotId AND 
                  NurseSchedule.nurseId = '".$nurseID."' ";

            $result1 = $conn->query($sql1);
            $row1 = mysqli_fetch_array($result1);

            $sql2 = "SELECT COUNT(*) AS C
            FROM vaccinationschedule
            WHERE timeSlotId = '".$timeSlotId."' ";    
            $result2 = $conn->query($sql2); 
            $row2 = mysqli_fetch_array($result2);

            if($availableSlots - $row2['C']  - $row1['numPatients'] <= 0) {
              echo "<script>
                  alert('Sorry. There the hospital is too busy! Next time please be aware that you may not successfully be able to cancel a time');
                  window.location.href='nurseCancelTime.php';
                  </script>";
            } else {

            $result = $conn->query($sql);
            $row = mysqli_fetch_array($result);
            $nurseID = $row['nurseId'];
            
          
            /*If nurse not in schedule give error*/
            $sql = "SELECT * FROM NurseSchedule
            WHERE nurseID = '".$nurseID."' and 
                  timeSlotId = '".$timeSlotId."' ";
            $result = $conn->query($sql);
            if ($result->num_rows === 0) {
              echo "<script>
                    alert('There was an error please try again!');
                    window.location.href='nurseCancelTime.php';
                    </script>";
            } else {
                  /*10 or less nurses a time slot keep each nurse to work on 10 patients*/
                if ($numNurses <= 10) {
                  /*Update the nurse + 1 and available lots +10 */
                  $newNurseTotal = $numNurses - 1;
                  $newAvailableSlots = $availableSlots - 10;
                  $sql = "UPDATE TimeSlot SET
                          numberOfNurses = '".$newNurseTotal."',
                          availableSlots = '".$newAvailableSlots."'
                          WHERE 
                          timeSlot = '".$newTimeSlot."'";
                  if ($conn->query($sql) !== TRUE) {
                    echo "<script>
                    alert('There was an error scheduling please try again');
                    window.location.href='nurseCancelTime.php';
                    </script>";
                  } 

                
                  $sql = "DELETE FROM  NurseSchedule
                          WHERE nurseID = '".$nurseID."' and 
                          timeSlotId = '".$timeSlotId."' ";
                
                  if ($conn->query($sql) !== TRUE) {
                    echo "<script>
                    alert('There was an error cancelling please try again.');
                    window.location.href='../nurse.php';
                    </script>";
                  } 
                  /*DONT NEED scheduleId CAN REMOVE OR KEEP TO KEEP TRACK OF THE MOST
                  RECENT SCHUEDLE.. SAME WITH SCHUEDULE TIME.
                  */
                  else {
                    $last_id = mysqli_insert_id($conn);
                    $sql = "UPDATE  Nurse SET scheduleId = NULL;
                            WHERE nurseId = '".$nurseID."'";
                    $conn->query($sql);
                    echo "<script>
                    alert('Successful Cancellation');
                    window.location.href='../nurse.php';
                    </script>";

                  }
                }

                /*11 nurses a time slot modify the number of patients each nurse can attend*/
                if ($numNurses == 11) {

                  $newNurseTotal = $numNurses -1;
                  $sql = "UPDATE TimeSlot SET
                          numberOfNurses = '".$newNurseTotal."'
                          WHERE 
                          timeSlot = '".$newTimeSlot."'";
                  $conn->query($sql);
                  $sql = "DELETE FROM  NurseSchedule
                          WHERE nurseID = '".$nurseID."' and 
                          timeSlotId = '".$timeSlotId."' ";
                  $conn->query($sql);
                  
                  $last_id = mysqli_insert_id($conn);
                  $sql = "UPDATE  Nurse SET scheduleId = NULL
                          WHERE nurseId = '".$nurseID."'";
                  $conn->query($sql);


                  $sql = "SELECT * FROM NurseSchedule
                          WHERE timeSlotId = '".$timeSlotId."' ";
                  $result = mysqli_query($conn, $sql);
                  $index = 0;
                  
                  while ($row = mysqli_fetch_assoc($result)) {
                      $sql = "UPDATE NurseSchedule
                      SET numPatients = 10
                      WHERE nurseId = '".$row['nurseID']."'";
                      $conn->query($sql);
                      $index++;
                  }
              
                  echo "<script>
                    alert('Successful Schedule');
                    window.location.href='../nurse.php';
                    </script>";

                }


                /*12 nurses a time slot modify the number of patients each nurse can attend*/
                else if ($numNurses == 12) {
                  $newNurseTotal = $numNurses -1;
                  $sql = "UPDATE TimeSlot SET
                          numberOfNurses = '".$newNurseTotal."'
                          WHERE 
                          timeSlot = '".$newTimeSlot."'";
                  $conn->query($sql);
                  $sql = "DELETE FROM  NurseSchedule
                          WHERE nurseID = '".$nurseID."' and 
                          timeSlotId = '".$timeSlotId."' ";
                  $conn->query($sql);
                  
                  $last_id = mysqli_insert_id($conn);
                  $sql = "UPDATE  Nurse SET scheduleId = NULL
                          WHERE nurseId = '".$nurseID."'";
                  $conn->query($sql);


                  $sql = "SELECT * FROM NurseSchedule
                          WHERE timeSlotId = '".$timeSlotId."' ";
                  $result = mysqli_query($conn, $sql);
                  $index = 0;
                  
                  
                  while ($row = mysqli_fetch_assoc($result)) {
                    if ($index == 0) {
                      $sql = "UPDATE NurseSchedule
                      SET numPatients = 10
                      WHERE nurseId = '".$row['nurseID']."'";
                    }else {
                      $sql = "UPDATE NurseSchedule
                      SET numPatients = 9
                      WHERE nurseId = '".$row['nurseID']."'";
                    }
                    $conn->query($sql);
                    $index++;
                  }
                  echo "<script>
                    alert('Successful Schedule');
                    window.location.href='../nurse.php';
                    </script>";
                }
            }
          }
        }
      }
    $conn->close();
  }
 ?>