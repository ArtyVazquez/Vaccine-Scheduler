<?php
      require_once '../includes/headerLoggedinDiffStyle.php';
      if($_SESSION['permissionType'] !== "P") {
        header("Location: ../index.php");
      }
?>

<div id="page-container">
    <div id="content-wrap">

        <h1 class="h1Home">Schedule Vaccination</h1>
        <p>Back To PATIENT Options
            <a href="../patient.php">Here</a>
        </p>
        <table>
            <tr>
                <th></th>
            </tr>
            <h3>*Enter the Vaccine Name and the Name of the company that makes it to check
                available times*</h3>
            <form action="?" method="post">
                <input
                    class="largerInput"
                    type="text"
                    name="vaccineName"
                    placeholder="Enter Vaccine Name">
                <input
                    class="largerInput"
                    type="text"
                    name="vaccineCompany"
                    placeholder="Enter the company who made this vaccine.">
                <button type="submit" name='submit'>View Times</button>
            </form>

            <?php
     if (isset($_POST['submit'])) {
      $vaccineName = $_POST['vaccineName'];
      $vaccineCompany = $_POST['vaccineCompany'];

      if (empty($vaccineName) || empty($vaccineCompany)) {
        echo "<script>
        alert('Enter Vaccine Name and Company');
        window.location.href='patientScheduleVaccination.php';
        </script>";
      }


      $Available = 0;
      $sql = "SELECT * FROM Vaccine 
      WHERE name = '".$vaccineName."' and
            companyName = '".$vaccineCompany."' and 
            availability > onHold";
      $result = $conn->query($sql);
      $row = mysqli_fetch_array($result);
      $Available = $row['availability'];
      $_SESSION['vaccineId'] = $row['vaccineId'];

      if ($Available <= 0) {
        echo "<script>
        alert('No Times Available. Please Try Again Later.');
        window.location.href='patientScheduleVaccination.php';
        </script>";
      }

      $sql = "SELECT * FROM TimeSlot 
      WHERE availableSlots > 0";
      $result = $conn->query($sql);

      echo "
      <table border>
      <h2>Times Available:</h2>
      <tr>
      </tr>";
      while($row = mysqli_fetch_array($result)) { 
        print "<tr>"; 
        print "<td>" . $row['timeSlot'] . "</td>";
        print "</tr>"; 
      } 
      echo "</table>"; 
      }
    ?>

        </table>

        <form action="patientScheduleVaccination-inc.php" method="post">
            <input
                class="largerInput"
                type="text"
                name="timeSlot"
                placeholder="Paste A Time From Above.">
            <button type="submit" name='submit'>SCHEDULE</button>
        </form>
        
    </div>

   

    <footer id="footer">
        <p class="pF">UI Health Covid Vaccination Database. Designed by Arturo Vazquez.
        </p>
    </footer>
</div>
</body>
</html>