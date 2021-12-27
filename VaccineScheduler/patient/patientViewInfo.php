<?php
      require_once '../includes/headerLoggedinDiffStyle.php';
      if($_SESSION['permissionType'] !== "P") {
        header("Location: index.php");
      }
?>

<div id="page-container">
    <div id="content-wrap">
        <h1 class="h1Home">VIEW PATIENT INFO</h1>
        <p>Back To PATIENT Options
            <a href="../patient.php">Here</a>
        </p>

        <table>
            <tr>
                <th></th>
            </tr>

<?php
    $userName = $_SESSION['username'];
    $password = $_SESSION['password'];
    $permissionType = $_SESSION['permissionType'];


    /*Query. TO obtain the info*/
    $sql = "SELECT * FROM Login,Patient WHERE 
    Login.idPermissionPatient = patientId and 
    Login.userName = '".$userName."' and 
    Login.permissionType = '".$permissionType."'";
    $result = $conn->query($sql);

    
    if ($result->num_rows === 0) {
      echo "<script>
      alert('There was an error please try again.');
      window.location.href='../patient.php';
      </script>";
    }else {

     
      $result = $conn->query($sql);
      $row = mysqli_fetch_array($result);
      $patientId = $row['patientId'];

      
      $sql = "SELECT * FROM Patient
              WHERE  patientId = '".$patientId."' ";

      $result = $conn->query($sql);
     

      if ($result->num_rows === 0) {
        echo "<script>
        alert('There was an error try again.');
        window.location.href='../patient.php';
        </script>";
      } else {

          /*Patient info*/
          echo "
          <h2>PATIENT INFO </h2>
          <table border=>
          <tr>
          <td>User Id: </td> 
          <td>Patient Id: </td> 
          <td>First Name: </td>
          <td>Middle Inital: </td>
          <td>Last Name: </td> 
          <td>SSN: </td> 
          <td>Age: </td> 
          <td>Gender: </td> 
          <td>Phone Number: </td>
          <td>Address: </td>
          <td>Medical History: </td>
          <td>Occupation: </td>
          </tr>";
          while($row = mysqli_fetch_array($result)) { 
            print "<tr>"; 
            print "<td>" . $row['userId'] . "</td>"; 
            print "<td>" . $row['patientId'] . "</td>"; 
            print "<td>" . $row['fName'] . "</td>"; 
            print "<td>" . $row['mi'] . "</td>"; 
            print "<td>" . $row['lName'] . "</td>"; 
            print "<td>" . $row['ssn'] . "</td>"; 
            print "<td>" . $row['age'] . "</td>";
            print "<td>" . $row['gender'] . "</td>";
            print "<td>" . $row['phoneNumber'] . "</td>";
            print "<td>" . $row['address'] . "</td>";
            print "<td>" . $row['medicalHistory'] . "</td>";
            print "<td>" . $row['occupation'] . "</td>";
            print "</tr>"; 
          } 
          echo "</table>"; 
          /*Schedule times*/
          $sql = "SELECT timeSlot FROM VaccinationSchedule, TimeSlot  
                  WHERE TimeSlot.timeSlotId =  VaccinationSchedule.timeSlotId AND 
                  VaccinationSchedule.patientId =  '".$patientId."'";
         $result = $conn->query($sql);
         echo "
          <h2>VACCINATION TIMES </h2>
          <table border=>
          <tr>
          <td>VACCINATION TIMES:</td> 
          </tr>";
          while($row = mysqli_fetch_array($result)) { 
            print "<tr>"; 
            print "<td>" . $row['timeSlot'] . "</td>"; 
            print "</tr>"; 
          } 
          echo "</table>"; 
          /*Vaccination history*/
          $sql = "SELECT * FROM VaccinationRecord, Vaccine 
                  WHERE VaccinationRecord.patientId =  '".$patientId."' AND 
                  VaccinationRecord.vaccineId = Vaccine.vaccineId";
          $result = $conn->query($sql);
          echo "
           <h2>Record Histrory</h2>
           <table border=>
           <tr>
           <td>Vaccine Taken: </td> 
           <td>Doses Taken:</td> 
           <td>Times: </td> 
           <td>Nurse ID: </td>
           </tr>";
           while($row = mysqli_fetch_array($result)) { 
             print "<tr>"; 
             print "<td>" . $row['name'] . "</td>"; 
             print "<td>" . $row['numberOfDoses'] . "</td>"; 
             print "<td>" . $row['timeSlot'] . "</td>"; 
             print "<td>" . $row['nurseId'] . "</td>";
             print "</tr>"; 
           } 
           echo "</table>"; 
      }   
    }
    $conn->close();
?>
        </table>
    </div>
    <footer id="footer">
        <p class="pF">UI Health Covid Vaccination Database. Designed by Arturo Vazquez.
        </p>
    </footer>
</div>
</body>
</html>