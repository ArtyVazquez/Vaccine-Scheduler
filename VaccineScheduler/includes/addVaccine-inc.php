<?php
  session_start();
  if (isset($_POST['submit'])) {
    require 'database.php';
    $vaccineName = $_POST['vaccineName'];
    $companyName = $_POST['companyName'];
    $numDosesImm = $_POST['numDosesImm'];
    $textualDescription = $_POST['textualDescription'];
    $availability = $_POST['availability'];


    /*Alter the user if there are any required input fields that need are not filled*/
    if (empty($vaccineName) || empty($companyName) || empty($availability)) {
      echo "<script>
      alert('Please Enter all of the required info.');
      window.location.href='../admin/addVaccine.php';
      </script>";
    } 
    
    else {
      /*Validate that number of doeses for immuization is an integer*/
      if (!empty($numDosesImm) && ctype_alpha($numDosesImm)) {
        echo "<script>
        alert('Please enter a number for the number of doeses');
        window.location.href='../admin/addVaccine.php';
        </script>";
      }
      /*Validate that number of vaccines added is an integer*/
      if (!empty($availability) && ctype_alpha($availability)) {
        echo "<script>
        alert('Please enter a number for the number of doeses');
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
          if (empty($numDosesImm) || empty( $textualDescription)) {
            echo "<script>
            alert('The entered Vaccine does not exisit please fill in all the info.');
            window.location.href='../admin/addVaccine.php';
            </script>";
          } else {
            $sql = "INSERT INTO Vaccine (name, companyName, numberDosesImm, textualDescription, availability, onHold)
                    VALUES('".$vaccineName."','".$companyName."','".$numDosesImm."','".$textualDescription."',
                    '".$availability."', 0)";
            $result = $conn->query($sql);
            if ($result->num_rows !== 0) {
              echo "<script>
              alert('Successfully added vaccine to the database.');
              window.location.href='../admin/addVaccine.php';
              </script>";
            } else {
              echo "<script>
              alert('An error occurred please try again');
              window.location.href='../admin/addVaccine.php';
              </script>";
            } 
          }
        } 

        /*The vaccine already exists. Update the availabilty of the vaccine*/
        else  {
            /*Update the vaccine tuple*/
            $row = mysqli_fetch_array($result);
            $vaccineID = $row['vaccineId']; 
            $numberAvail = $row['availability']; 
            $totalNowAvail = $numberAvail + $availability;

            $sql = "UPDATE Vaccine SET
            availability = '".$totalNowAvail."'
            WHERE vaccineId = '".$vaccineID."' ";
           
            if ($conn->query($sql) === TRUE) {
              echo "<script>
              alert('Successfully added additional doeses of the vaccine.');
              window.location.href='../admin/addVaccine.php';
              </script>";
            } else {
              echo "<script>
              alert( $vaccineID);
              window.location.href='../admin/addVaccine.php';
              </script>";
            }
          }
        }
      }
    }
    $conn->close();
 ?>