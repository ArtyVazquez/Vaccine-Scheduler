<?php
       require_once '../includes/headerLoggedinDiffStyle.php';
      if($_SESSION['permissionType'] !== "N") {
        header("Location: index.php");
      }
  ?>

<div id="page-container">
    <div id="content-wrap">
        <h1 class="h1Home">UPDATE NURSE</h1>
        <p>Back To NURSE Options
            <a href="../nurse.php">Here</a>
        </p>
        <p>*You may update both, just the phone number, or just the address*</p>
        <form action="nurseUpdate-inc.php" method="post">
            <input
                class="largerInput"
                type="text"
                name="phoneNumber"
                placeholder="Enter Phone number eg. 773-111-1111">
            <input
                class="largerInputText"
                type="text"
                name="address"
                placeholder="Enter Address e.g 1200 W Harrison St, Chicago, IL 60607">
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