<?php
    require_once 'includes/headerLoggedin.php';
    if($_SESSION['permissionType'] !== "P") {
      header("Location: index.php");
    }
?>
<div id="page-container">
    <div id="content-wrap">
        <h1 class="h1Home">PATIENT VIEW</h1>
        <h2>You may do the following:</h2>
        <form action="patient/patientUpdateInfo.php" method="post">
            <button onclick="patientUpdateInfo.php">Update Info</button>
        </form>
        <form action="patient/patientScheduleVaccination.php" method="post">
            <button onclick="patientScheduleVaccination.php">Schedule Vaccination</button>
        </form>
        <form action="patient/patientCancelTime.php" method="post">
            <button onclick="patientCancelTime.php">Cancel A Time</button>
        </form>
        <form action="patient/patientViewInfo.php" method="post">
            <button onclick="patientViewInfo.php">View Info</button>
        </form>
    </div>
    <footer id="footer">
        <p class="pF">UI Health Covid Vaccination Database. Designed by Arturo Vazquez.
        </p>
    </footer>
</div>
</body>
</html>