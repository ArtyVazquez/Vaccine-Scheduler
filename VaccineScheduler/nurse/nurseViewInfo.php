<?php
       require_once '../includes/headerLoggedinDiffStyle.php';
      if($_SESSION['permissionType'] !== "N") {
        header("Location: index.php");
      }
  ?>

<div id="page-container">
    <div id="content-wrap">
        <h1 class="h1Home">VIEW NURSE INFO</h1>
        <p>Back To NURSE Options
            <a href="../nurse.php">Here</a>
        </p>
        <table>
            <tr>
                <th></th>
            </tr>
        <?php
        $userName = $_SESSION['username'];
        $password = $_SESSION['password'];
        $permissionType = $_SESSION['permissionType'];
        
        /*Query. To obtain the info*/
        $sql = "SELECT * FROM Login,Nurse where 
        Login.idPermissionNurse = Nurse.nurseId and 
        Login.userName = '".$userName."' and 
        Login.permissionType = '".$permissionType."'";
        $result = $conn->query($sql);

        if ($result->num_rows === 0) {
          echo "<script>
          alert('There was an error please try again.');
          window.location.href='../nurse.php';
          </script>";
        }else {
          $result = $conn->query($sql);
          $row = mysqli_fetch_array($result);
          $nurseID = $row['nurseId'];
          
          $sql = "SELECT * FROM NURSE
                  WHERE nurseId = '".$nurseID."'";
          $result = $conn->query($sql);

          if ($result->num_rows === 0) {
            echo "<script>
            alert('There was an error try again.');
            window.location.href='nurseViewInfo.php';
            </script>";
          } else {

              /*Print info except the times that the nureses are schedule for*/
              echo "
              <h2>Nurse Info</h2>
              <table border=>
              <tr>
              <td>Nurse Id: </td> 
              <td>First Name: </td>
              <td>Middle Inital: </td>
              <td>Last Name: </td> 
              <td>Age: </td> 
              <td>Gender: </td> 
              <td>Phone Number: </td>
              <td>Address: </td>
              
              </tr>";
              while($row = mysqli_fetch_array($result)) { 
                print "<tr>"; 
                print "<td>" . $row['nurseId'] . "</td>"; 
                print "<td>" . $row['fName'] . "</td>"; 
                print "<td>" . $row['mi'] . "</td>"; 
                print "<td>" . $row['lName'] . "</td>"; 
                print "<td>" . $row['age'] . "</td>";
                print "<td>" . $row['gender'] . "</td>";
                print "<td>" . $row['phoneNumber'] . "</td>";
                print "<td>" . $row['address'] . "</td>";
                print "</tr>"; 
              } 
              echo "</table>"; 

              /*Print the time that nurses are scheduled for*/
              $sql = "SELECT * FROM TimeSlot,NurseSchedule 
                      WHERE NurseSchedule.timeSlotId = TimeSlot.timeSlotId and 
                            NurseSchedule.nurseID = '".$nurseID."' ";
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