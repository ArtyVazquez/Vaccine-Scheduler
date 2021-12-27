<?php
    require_once 'includes/headerLoggedin.php';
    if($_SESSION['permissionType'] !== "A") {
      header("Location: index.php");
    }
?>

<div id="page-container">
    <div id="content-wrap">
            <h1 class="h1Home">ADMIN VIEW</h1>
            <h2>You may do the following:</h2>
            
            <form action="admin/adminRegisterNurse.php" method="post">
                <button onclick="adminRegisterNurse.php">Register Nurse</button>
            </form>

            <form action="admin/updateNurse.php" method="post">
                <button onclick="updateNurse.php">Update Nurse</button>
            </form>

            <form action="admin/deleteNurse.php" method="post">
                <button onclick="deleteNurse.php">Delete Nurse</button>
            </form>

            <form action="admin/addVaccine.php" method="post">
                <button onclick="addVaccine.php">Add Vaccine</button>
            </form>

            <form action="admin/updateVaccine.php" method="post">
                <button onclick="updateVaccine.php">Update Vaccine</button>
            </form>

            <form action="admin/addTimeSlots.php" method ="post">
                <button onclick="addTimeSlots.php">Add Time Slots</button>
            </form>

            <form action="admin/ViewNurse.php" method="post">
                <button onclick="ViewNurse.php">View Nurse Info</button>
            </form>

            <form action="admin/ViewPatient.php" method="post">
                <button onclick="ViewPatient.php">View Patient Info</button>
            </form>
    </div>
    <footer id="footer">
        <p class="pF">UI Health Covid Vaccination Database. Designed by Arturo Vazquez.
        </p>
    </footer>
</div>
</body>
</html>