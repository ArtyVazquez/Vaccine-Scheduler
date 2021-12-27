<?php
  session_start();
  if (isset($_POST['submit'])) {
    //ADD database connection
    require 'database.php';
    $nurseUserName = $_POST['nurseUserName'];
    $nurseFname = $_POST['nurseFname'];
    $nurseLname = $_POST['nurseLname'];
    

    /*Validate that the user is entering all fields*/
    if (empty($nurseUserName) || empty($nurseFname) || empty($nurseLname)) {
      echo "<script>
      alert('Please enter all of the following nurse username, first name, and last name');
      window.location.href='../admin/deleteNurse.php';
      </script>";
    } 
    
    else {
      /*Validate that the user is entering first, last names that only have letters*/
      if ((!empty($fName) && !ctype_alpha($fName))|| (!empty($lName) && !ctype_alpha($lName))) {
        echo "<script>
        alert('Name must contain only letters.');
        window.location.href='../admin/deleteNurse.php';
        </script>";
      } 
    

      else {

        /*Query to get table with the same user name.*/
        $sql = "SELECT * FROM Login,Nurse 
                WHERE 
                Login.idPermissionNurse = Nurse.nurseId and 
                Login.userName = '".$nurseUserName."' and 
                Nurse.fName = '".$nurseFname."' and
                Nurse.lName = '".$nurseLname."' ";
        $result = $conn->query($sql);
        if ($result->num_rows < 1) {
          echo "<script>
          alert('Nurse does not exist please verify nurse username, first name, and last name');
          window.location.href='../admin/deleteNurse.php';
          </script>";
        } else  {

          $row = mysqli_fetch_array($result);
          $nurseID = $row['nurseId']; 
          $userID = $row['userId']; 

          /*Check that the nurse does not have scheduled times after the day of deletion if so give an error*/
          $sql = "SELECT timeSlot
                  FROM nurse, nurseschedule, timeslot
                  WHERE nurse.nurseId = nurseschedule.nurseID AND
                  nurseschedule.timeSlotId = timeslot.timeSlotId
                  and nurse.nurseId = '".$nurseID."' ";
          $result = $conn->query($sql);
          $flag = FALSE;

          while($row = mysqli_fetch_array($result)) {
            $timeSlotOld = substr($row['timeSlot'], 0,10);
            echo '<p> '.$timeSlotOld.' </p>';
             $timeSlotOldT = strtr($timeSlotOld, '-', '/');
             $timeSlotNew = date('Y-m-d', strtotime($timeSlotOldT));
            
            if (strtotime($timeSlotNew) > time()) {
              echo "<script>
              alert('Nurse has schedule times. Unsuccessful Delete.');
              window.location.href='../admin/deleteNurse.php';
              </script>";
              $flag = TRUE;
            }
          }          

          /*Will only delete nurse if he/she does not have any scheduled timeslots*/
          if ($flag != TRUE) {
            /*Query to delete nurse database*/
            $sql = "DELETE FROM Nurse WHERE nurseId = '".$nurseID."' ";
           $sql2 = "DELETE FROM Login WHERE userId = '".$userID."' ";
            if ($conn->query($sql) === TRUE  && $conn->query($sql2) === TRUE) {
              echo "<script>
                alert('Nurse Successfully Deleted.');
                window.location.href='../admin/deleteNurse.php';
                </script>";
            } else {
              echo "<script>
                alert('An Error occured. Deletion did not occur.');
                window.location.href='../admin/deleteNurse.php';
                </script>";
            }
          }

        }
      }
    }
    $conn->close();
  }
 ?>