<?php
    require_once 'includes/header.php';
  ?>
<div id="page-container">
    <div id="content-wrap">
        <h1 class="h1Home">REGISTER</h1>
        <p>ALREADY HAVE AN ACCOUNT?
            <a href="login.php">LOGIN!</a>
        </p>
        <p>
            *Note that you may only register if you are a patient.*</p>
        <form action="includes/register-inc.php" method="post">
            <h3>Name:</h3>
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
            <h3>Personal Info:</h3>
            

            <select class="choose" name="gender">
                <option value="" disabled selected>Gender</option>
                <option value="M">Male</option>
                <option value="F">Female</option>
            </select>


            <input class="largerInput" type="text" name="ssn" placeholder="Enter SSN">
            <input class="largerInput" type="text" name="age" placeholder="Enter Age">
            <input
                class="largerInput"
                type="text"
                name="occupation"
                placeholder="Enter Occupation(optional)">
            <input
                class="largerInput"
                type="text"
                name="phoneNumber"
                placeholder="Enter Phone Number e.g. 773-111-1111">
            <input
                class="largerInputText"
                type="text"
                name="address"
                placeholder="Enter Address e.g 1200 W Harrison St, Chicago, IL 60607">
            <h3>Login Info:</h3>
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