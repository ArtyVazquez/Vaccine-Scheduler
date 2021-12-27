<?php
session_start();
if (isset($_POST['submit'])) {
      //ADD database connection
      require '../includes/database.php';
      $date = date("m-d-Y", strtotime($_POST['date']));
      $time = date('h:i A', strtotime($_POST['time']));


      $newTimeSlot = $date . " ". $time;
     

      /*Check if the time slot is available*/
      $sql = "SELECT * FROM TimeSlot where 
              timeSlot = '".$newTimeSlot."'";
      $result = $conn->query($sql);

      /*If row not 0 time slot exists*/
      if ($result->num_rows !== 0) {
        echo "<script>
          alert('This time slot already exists.');
          window.location.href='../admin/addTimeSlots.php';
          </script>";
      } else {
        $sql = "INSERT INTO timeslot(timeSlot, numberOfNurses, availableSlots) 
                VALUES('".$newTimeSlot ."', 0, 0)";
         if ($conn->query($sql) !== TRUE) {
            echo "<script>
            alert('There was an error scheduling please try again.');
            window.location.href='../admin.php';
            </script>";
          } else {
            echo "<script>
            alert('Successful.');
            window.location.href='../admin.php';
            </script>";
          }
        
      }
    $conn->close();
  }
 ?>