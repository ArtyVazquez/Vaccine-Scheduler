<?php
     require_once '../includes/headerLoggedinDiffStyle.php';
     if($_SESSION['permissionType'] !== "A") {
       header("Location: index.php");
     }
  ?>

<div id="page-container">
    <div id="content-wrap">
        <h1 class="h1Home">ADD VACCINE</h1>
        <p>Back To Admin Options
            <a href="../admin.php">Here</a>
        </p>
        <form action="../includes/addVaccine-inc.php" method="post">
            <p>
                *Vaccine must be new. OTHERWISE:
                <a href="updateVaccine.php">Here</a>*</p>
            <input
                class="largerInput"
                type="text"
                name="vaccineName"
                placeholder="Vaccine Name(Required)">
            <input
                class="largerInput"
                type="text"
                name="companyName"
                placeholder="Company Name(Required)">
            <input
                class="largerInput"
                type="text"
                name="numDosesImm"
                placeholder="Immunization Doses(Required)">
            <input
                class="largerInput"
                type="text"
                name="textualDescription"
                placeholder="Textual Description(Required)">
            <input
                class="largerInput"
                type="text"
                name="availability"
                placeholder="Number of doeses to Add(Required)">
            <button type="submit" name='submit'>ADD</button>
        </form>
    </div>
    <footer id="footer">
        <p class="pF">UI Health Covid Vaccination Database. Designed by Arturo Vazquez.
        </p>
    </footer>
</div>
</body>
</html>