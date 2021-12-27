<?php
  session_start();
  if (isset($_POST['submit'])) {
    //ADD database connection
    require 'database.php';
    $vaccineName = $_POST['vaccineName'];
    $companyName = $_POST['companyName'];
    $availability = $_POST['availability'];


    /*Alter the user if there are any required input fields that need are not filled*/
    if (empty($vaccineName) || empty($companyName) || empty($availability)) {
      echo "<script>
      alert('Please Enter all of the required info.');
      window.location.href='../admin/addVaccine.php';
      </script>";
    } 
    
    else {
      /*Validate that number of vaccines updated is an integer*/
      if (!empty($availability) && ctype_alpha($availability)) {
        echo "<script>
        alert('Please enter a number for the number of doses');
        window.location.href='../admin/addVaccine.php';
        </script>";
      }
        else {
        /*Query to get table with the the vaccine that matches the companmy name and name of vaccine*/
        $sql = "SELECT * FROM Vaccine where 
                                      name = '".$vaccineName."' and
                                      companyName = '".$companyName."'";
        $result = $conn->query($sql);
        /*Vaccine does not exists*/
        if ($result->num_rows === 0) {
              echo "<script>
              alert('The Vaccine does not exists in the database please try again.');
              window.location.href='../admin/updateVaccine.php';
              </script>";
        } 
          
         

        /*The vaccine exists. Now check that no more than the onhold can be deleted*/
        else  {

            /*Update the vaccine tuple*/
            $row = mysqli_fetch_array($result);
            $vaccineID = $row['vaccineId']; 
            $onHold = $row['onHold']; 
            $totalSoFar = $row['availability'];
            

            if (($totalSoFar + $availability) < $onHold) {
              echo "<script>
              alert('Unable to update.');
              window.location.href='../admin/updateVaccine.php';
              </script>";
            } else {
              $sql = "UPDATE Vaccine SET
              availability = availability + '".$availability."'
              WHERE vaccineId = '".$vaccineID."' ";
             
              if ($conn->query($sql) === TRUE) {
                echo "<script>
                alert('Successfully vaccine doses updated.');
                window.location.href='../admin.php';
                </script>";
              } else {
                echo "<script>
                alert('An error has occurred. Please try again.');
                window.location.href='../admin/addVaccine.php';
                </script>";
              }
            }
          }
        }
      }
    }
    
    $conn->close();
 ?>