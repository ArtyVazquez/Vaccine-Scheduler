<?php
    require_once '../includes/headerLoggedinDiffStyle.php';
     if($_SESSION['permissionType'] !== "A") {
       header("Location: index.php");
     }
  ?>

<div id="page-container">
    <div id="content-wrap">
        <h1 class="h1Home">REGISTER NURSE</h1>
        <p>Back To ADMIN Options
            <a href="../admin.php">Here</a>
        </p>
        <p>
            *Note that you may only register a Nurse.*</p>

        <form action="../includes/registerNurse-inc.php" method="post">
            <h2 for="Name">Name:</h2>
            <input
                class="largerInput"
                type="text"
                name="fName"
                placeholder="Enter First Name">
            <input
                class="largerInput"
                type="text"
                name="mi"
                placeholder="Enter Midde Inital(optional)">
            <input
                class="largerInput"
                type="text"
                name="lName"
                placeholder="Enter Last Name">
            <h2 for="Name">Personal Info:</h2>
            <select class="choose" name="gender">
                <option value="" disabled selected>Gender</option>
                <option value="M">Male</option>
                <option value="F">Female</option>
            </select>
            
            <input class="largerInput" type="text" name="age" placeholder="Enter Age">
            <input
                class="largerInput"
                type="text"
                name="phoneNumber"
                placeholder="Enter Phone Number eg. 773-111-1111">
            <input
                class="largerInputText"
                type="text"
                name="address"
                placeholder="Enter Address e.g 1200 W Harrison St, Chicago, IL 60607">
            <h2 for="login">Login Info:</h2>
            <input
                class="largerInput"
                type="text"
                name="username"
                placeholder="Enter Username">
            <input
                class="largerInput"
                type="password"
                name="password"
                placeholder="Enter Password">
            <input
                class="largerInput"
                type="password"
                name="confirmPassword"
                placeholder="Confirm Password">
            <button type="submit" name='submit'>REGISTER</button>
        </form>

    </div>
    <footer id="footer">
        <p class="pF">UI Health Covid Vaccination Database. Designed by Arturo Vazquez.
        </p>
    </footer>
</div>
</body>
</html>