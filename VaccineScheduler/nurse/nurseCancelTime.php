<?php
    require_once '../includes/headerLoggedinDiffStyle.php';
    if($_SESSION['permissionType'] !== "N") {
        header("Location: ../index.php");
    }
  ?>

<div id="page-container">
    <div id="content-wrap">
        <h1 class="h1Home">CANCEL A TIME</h1>
        <p>Back To NURSE Options
            <a href="../nurse.php">Here</a>
        </p>
        <form action="nurseCancelTime-inc.php" method="post">
        <h2> Date:</h2>
            <br>
            <input
                style="font-size:2.5rem"
                type="date"
                name="date"
                value="2021-03-23"
                min="2021-03-23"
                max="2031-03-23">
                <br>
                <br>
            <h2>Time:</h2>
            <input
                style="font-size:2.5rem"
                type="time"
                name="time"
                min="09:00"
                max="16:00"
                step='3600'
                required="required">
                <br>
                <br>
                <br>
                <br>
            <button type="submit" name='submit'>Cancel</button>
        </form>
    </div>
    <footer id="footer">
        <p class="pF">UI Health Covid Vaccination Database. Designed by Arturo Vazquez.
        </p>
    </footer>
</div>
</body>
</html>