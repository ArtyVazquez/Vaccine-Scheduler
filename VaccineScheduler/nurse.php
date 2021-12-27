<?php
    require_once 'includes/headerLoggedin.php';
    if($_SESSION['permissionType'] !== "N") {
      header("Location: index.php");
    }
?>
<div id="page-container">
    <div id="content-wrap">
        <h1 class="h1Home">NURSE VIEW</h1>
        <h2>You may do the following:</h2>
        <form action="nurse/nurseUpdate.php" method="post">
            <button onclick="nurseUpdate.php">Update Info</button>
        </form>
        <form action="nurse/nurseScheduleTime.php" method="post">
            <button onclick="nurseScheduleTime.php">Schedule time</button>
        </form>
        <form action="nurse/nurseCancelTime.php" method="post">
            <button onclick="nurseCancelTime.php">Cancel a time</button>
        </form>
        <form action="nurse/nurseViewInfo.php" method="post">
            <button onclick="nurseViewInfo.php">View Info</button>
        </form>
        <form action="nurse/nurseRecordVaccine.php" method="post">
            <button onclick="nurseRecordVaccine.php">Record Vaccination</button>
        </form>
    </div>
    <footer id="footer">
        <p class="pF">UI Health Covid Vaccination Database. Designed by Arturo Vazquez.
        </p>
    </footer>
</div>
</body>
</html>