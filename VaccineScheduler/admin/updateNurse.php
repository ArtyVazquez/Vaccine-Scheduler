<?php
    require_once '../includes/headerLoggedinDiffStyle.php';
    if($_SESSION['permissionType'] !== "A") {
      header("Location: index.php");
    }
?>

<div id="page-container">
    <div id="content-wrap">
        <h1 class="h1Home">UPDATE NURSE</h1>
        <p>Back To ADMIN Options
            <a href="../admin.php">Here</a>
        </p>
        <form action="../includes/updateNurse-inc.php" method="post">
            <p>*You must fill the following to update a nurse*</p>
            <input
                class="largerINput"
                type="text"
                name="nurseUserName"
                placeholder="Nurse Username">
            <input
                class="largerINput"
                type="text"
                name="nurseFname"
                placeholder="Nurse First Name">
            <input
                class="largerINput"
                type="text"
                name="nurseLname"
                placeholder="Nurse Last Name">
            <br>
            <br>
            <br>
            <p>*You can update the following: *</p>
            <input class="largerINput" type="text" name="fName" placeholder="First Name">
            <input class="largerINput" type="text" name="mi" placeholder="Midde Inital">
            <input class="largerINput" type="text" name="lName" placeholder="Last Name">
            <select class="choose" name="gender">
                <option value="" disabled="disabled" selected="selected">Gender</option>
                <option value="M">Male</option>
                <option value="F">Female</option>
            </select>
            <input class="largerINput" type="text" name="age" placeholder="Age">
            <input class="largerINput" type="text" name="username" placeholder="Username">
            <input
                class="largerINput"
                type="password"
                name="password"
                placeholder="Password">
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