<?php
       require_once '../includes/headerLoggedinDiffStyle.php';

      if($_SESSION['permissionType'] !== "N") {
        header("Location: ../index.php");
      }
?>

<div id="page-container">
    <div id="content-wrap">
        <h1 class="h1Home">RECORD VACCINATION</h1>
        <p>Back To NURSE Options
            <a href="../nurse.php">Here</a>
        </p>
        <form action="nurseRecordVaccine-inc.php" method="post">
            <input
                class="largerInput"
                type="text"
                name="vaccineId"
                placeholder="Enter the Vaccine ID">
            <input
                class="largerInput"
                type="text"
                name="patientId"
                placeholder="Enter Patient ID">
            <input
                class="largerInput"
                type="text"
                name="doseNumber"
                placeholder="Enter Number Of Doses Given">
            <input
                class="largerInput"
                type="text"
                name="timeSlot"
                placeholder="Time: e.g. 03-23-2021 09:00 AM">
            <button type="submit" name='submit'>RECORD</button>
        </form>
    </div>
    <footer id="footer">
        <p class="pF">UI Health Covid Vaccination Database. Designed by Arturo Vazquez.
        </p>
    </footer>
</div>
</body>
</html>