<?php
    require_once '../includes/headerLoggedinDiffStyle.php';
    if($_SESSION['permissionType'] !== "A") {
      header("Location: index.php");
    }
  ?>

<div id="page-container">
    <div id="content-wrap">
        <h1 class="h1Home">DELETE NURSE</h1>
        <p>Back To ADMIN Options
            <a href="../admin.php">Here</a>
        </p>

        <form action="../includes/deleteNurse-inc.php" method="post">
            <p>
                *Enter the following to delete: *</p>
            <input
                class="largerInput"
                type="text"
                name="nurseUserName"
                placeholder="Nurse Username">
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
            <button type="submit" name='submit'>DELETE</button>
        </form>
    </div>
    <footer id="footer">
        <p class="pF">UI Health Covid Vaccination Database. Designed by Arturo Vazquez.
        </p>
    </footer>
</div>
</body>
</html>