<?php
      require_once '../includes/headerLoggedinDiffStyle.php';
      if($_SESSION['permissionType'] !== "A") {
        header("Location: index.php");
      }
?>

<div id="page-container">
    <div id="content-wrap">
        <h1 class="h1Home">VIEW NURSE INFO</h1>
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
                    name="nurseUserName"
                    placeholder="Nurse username">
                <input
                    class="largerInput"
                    type="text"
                    name="nurseFname"
                    placeholder="Nurse First Name">
                <input
                    class="largerInput"
                    type="text"
                    name="nurseLname"
                    placeholder="Nurse Last Name">
                <button type="submit" name='submit'>View</button>
            </form>
        <?php
      if (isset($_POST['submit'])) {
        $nurseUserName = $_POST['nurseUserName'];
        $nurseFname = $_POST['nurseFname'];
        $nurseLname = $_POST['nurseLname'];
    

        /*Alter the user if there are any required input fields that need are not filled*/
        if (empty($nurseUserName) || empty($nurseFname) || empty($nurseLname)) {
          echo "<script>
          alert('Please enter all of the following nurse username, first name, and last name');
          window.location.href='ViewNurse.php';
          </script>";
        } 
        
        else {
          /*Validate that the user is entering first, last names that only have letters*/
          if ((!empty($nurseFname) && !ctype_alpha($nurseFname)) || (!empty($nurseLname) && !ctype_alpha($nurseLname))) {
            echo "<script>
            alert('Name must contain only letters.');
            window.location.href='ViewNurse.php';
            </script>";
          } else {
            /*Query to get table with the same user name.*/
            $sql = "SELECT * FROM Login,Nurse where 
                                                    Login.idPermissionNurse = Nurse.nurseId and 
                                                    Login.userName = '" . $nurseUserName . "' and 
                                                    Nurse.fName = '" . $nurseFname . "' and
                                                    Nurse.lName = '" . $nurseLname . "' ";
            $result = $conn->query($sql);
            /*Check if the nurse exists*/
            if ($result->num_rows === 0) {
              echo "<script>
              alert('Nurse does not exist please verify nurse username, first name, and last name');
              window.location.href='ViewNurse.php';
              </script>";
            } else {
              /*Query to insert patient into the database*/        
        
              /*Print the nurse info*/
              echo "
              <h2>Nurse INFO</h2>
              <table border=>
              <tr>
              <td>User Id: </td> 
              <td>User Name: </td> 
              <td>Password: </td> 
              <td>Nurse Id: </td> 
              <td>First Name: </td>
              <td>Middle Inital: </td>
              <td>Last Name: </td> 
              <td>Age: </td> 
              <td>Gender: </td> 
              <td>Phone Number: </td>
              <td>Address: </td>
              
              </tr>";
              $nurseId = 0;
              while($row = mysqli_fetch_array($result)) { 
                print "<tr>"; 
                print "<td>" . $row['userId'] . "</td>"; 
                print "<td>" . $row['userName'] . "</td>"; 
                print "<td>" . $row['userPassword'] . "</td>";
                print "<td>" . $row['nurseId'] . "</td>"; 
                print "<td>" . $row['fName'] . "</td>"; 
                print "<td>" . $row['mi'] . "</td>"; 
                print "<td>" . $row['lName'] . "</td>"; 
                print "<td>" . $row['age'] . "</td>";
                print "<td>" . $row['gender'] . "</td>";
                print "<td>" . $row['phoneNumber'] . "</td>";
                print "<td>" . $row['address'] . "</td>";
                print "</tr>"; 
                $nurseId = $row['nurseId'];
              } 
              echo "</table>"; 

            
              /*Print the time that nurses are scheduled for*/
              $sql = "SELECT * FROM TimeSlot,NurseSchedule 
              WHERE NurseSchedule.timeSlotId = TimeSlot.timeSlotId and 
                    NurseSchedule.nurseID = '".$nurseId."' ";
                $result = $conn->query($sql);


              echo "
              <h2>Time Slots</h2>
              <table border=>
              <tr>
              <td>Time Slots:</td> 
              </tr>";
              while($row = mysqli_fetch_array($result)) { 
                print "<tr>"; 
                print "<td>" . $row['timeSlot'] . "</td>";
                print "</tr>"; 
              } 
              echo "</table>"; 

            }
            $conn->close();
          }
        }
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