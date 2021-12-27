<?php
      require_once '../includes/headerLoggedinDiffStyle.php';
      if($_SESSION['permissionType'] !== "P") {
        header("Location: ../index.php");
      }
?>
<div id="page-container">
    <div id="content-wrap">
        <h1 class="h1Home">Update Info</h1>
        <p>Back To PATIENT Options
            <a href="../patient.php">Here</a>
        </p>
        <p>*You may update one or more of the following:*</p>
        <form action="patientUpdateInfo-inc.php" method="post">

            <h2 for="Name">Name:</h2>
            <input class="largerInput" type="text" name="fName" placeholder="First Name">
            <input class="largerInput" type="text" name="mi" placeholder="Midde Inital">
            <input class="largerInput" type="text" name="lName" placeholder="Last Name">

            <h2 for="Personal Info">Personal Info:</h2>
            <select class="choose" name="gender">
                <option value="" disabled="disabled" selected="selected">Gender</option>
                <option value="M">Male</option>
                <option value="F">Female</option>
            </select>
            <input class="largerInput" type="text" name="age" placeholder="Age">
            <input
                class="largerInput"
                type="text"
                name="phoneNumber"
                placeholder="Phone Number e.g. 773-111-1111">
            <input
                class="largerInputText"
                type="text"
                name="address"
                placeholder="Address e.g 1200 W Harrison St, Chicago, IL 60607">
            <input
                class="largerInput"
                type="text"
                name="occupation"
                placeholder="Occupation">
            <input class="largerInput" type="text" name="SSN" placeholder="SSN">

            <h2 for="Login Info">Login Info:</h2>
            <input class="largerInput" type="text" name="username" placeholder="Username">
            <input
                class="largerInput"
                type="password"
                name="password"
                placeholder="Password">
            <button type="submit" name='submit'>Update</button>

        </form>
    </div>
    <footer id="footer">
        <p class="pF">UI Health Covid Vaccination Database. Designed by Arturo Vazquez.
        </p>
    </footer>
</div>
</body>
</html>