<?php
        require_once '../includes/headerLoggedinDiffStyle.php';
        if($_SESSION['permissionType'] !== "A") {
          header("Location: index.php");
        }
?>

<div id="page-container">
    <div id="content-wrap">
        <h1 class="h1Home">UPDATE VACCINE</h1>
        <p>Back To Admin Options
            <a href="../admin.php">Here</a>
        </p>
        <form action="../includes/updateVaccine-inc.php" method="post">
            <p>ENTER THE FOLLOWING:</p>
            <input
                class="largerInput"
                type="text"
                name="vaccineName"
                placeholder="Vaccine Name">
            <input
                class="largerInput"
                type="text"
                name="companyName"
                placeholder="Company Name">
            <input
                class="largerInput"
                type="text"
                name="availability"
                placeholder="Number of doses(+ to add - to delete)">
            <button type="submit" name='submit'>UPDATE</button>
        </form>
    </div>
    <footer id="footer">
        <p class="pF">UI Health Covid Vaccination Database. Designed by Arturo Vazquez.
        </p>
    </footer>
</div>
</body>
</html>