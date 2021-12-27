<?php
    require_once '../includes/headerLoggedinDiffStyle.php';
    if($_SESSION['permissionType'] !== "A") {
      header("Location: index.php");
    }
  ?>

<div id="page-container">
    <div id="content-wrap">
        <h1 class="h1Home">VIEW PATIENT INFO</h1>
        <p>Back To ADMIN Options
            <a href="../admin.php">Here</a>
        </p>
        <table>
            <tr>
                <th></th>
            </tr>
            <h3>ENTER THE FOLLOWING:</h3>
            <form action="?" method="post">
                <input
                    class="largerInput"
                    type="text"
                    name="patientUserName"
                    placeholder="Patient username">
                <input
                    class="largerInput"
                    type="text"
                    name="patientFname"
                    placeholder="Patient First Name">
                <input
                    class="largerInput"
                    type="text"
                    name="patientLname"
                    placeholder="Patient Last Name">
                <button type="submit" name='submit'>View</button>
            </form>
        <?php
      //session_start();
      if (isset($_POST['submit'])) {
        //ADD database connection
        // require 'database.php';
        $patientUserName = $_POST['patientUserName'];
        $patientFname = $_POST['patientFname'];
        $patientLname = $_POST['patientLname'];
    

        /*Alter the user if there are any required input fields that need are not filled*/
        if (empty($patientUserName) || empty($patientFname) || empty($patientLname)) {
          echo "<script>
          alert('Please enter all of the following nurse username, first name, and last name');
          window.location.href='ViewPatient.php';
          </script>";
        } 
        
        else {
          /*Validate that the user is entering first, last names that only have letters*/
          if ((!empty($patientFname) && !ctype_alpha($patientFname)) || (!empty($patientLname) && !ctype_alpha($patientLname))) {
            echo "<script>
            alert('Name must contain only letters.');
            window.location.href='ViewPatient.php';
            </script>";
          } else {
            /*Query to get table with the same user name.*/
            $sql = "SELECT * FROM Login,Patient where 
                                                    Login.idPermissionPatient = Patient.PatientId and 
                                                    Login.userName = '" . $patientUserName . "' and 
                                                    Patient.fName = '" . $patientFname . "' and
                                                    Patient.lName = '" . $patientLname . "' ";
            $result = $conn->query($sql);
            /*Check if the user name is already taken if not then add of the fields are valid*/
            if ($result->num_rows === 0) {
              echo "<script>
              alert('Patient does not exist please verify patient username, first name, and last name');
              window.location.href='ViewPatient.php';
              </script>";
            } else {
              /*Query to insert patient into the database*/        
        
              /*Print the patient info*/
              echo "
              <h2>PATINET INFO</h2>
              <table border=>
              <tr>
              <td>User Id: </td> 
              <td>User Name: </td> 
              <td>Password: </td> 
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
                print "<td>" . $row['userName'] . "</td>"; 
                print "<td>" . $row['userPassword'] . "</td>";
                print "<td>" . $row['patientId'] . "</td>";
                $patientId = $row['patientId']; /*To be used in the query bellow*/ 
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
              /*Print the schedule time*/
              $sql = "SELECT timeSlot FROM VaccinationSchedule, TimeSlot  
                  WHERE TimeSlot.timeSlotId =  VaccinationSchedule.timeSlotId AND 
                  VaccinationSchedule.patientId =  '".$patientId."'";
              $result = $conn->query($sql);
              echo "
                <h2>VACCINATION TIMES </h2>
                <table border=>
                <tr>
                <td>VACCINATION TIME: </td>
                </tr>";
                while($row = mysqli_fetch_array($result)) { 
                  print "<tr>"; 
                  print "<td>" . $row['timeSlot'] . "</td>"; 
                  print "</tr>"; 
                } 
                echo "</table>"; 


              /*Print the vaccination record*/
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
        } 
      $conn->close();
      }
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