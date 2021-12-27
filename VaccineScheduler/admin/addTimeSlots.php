<?php
        require_once '../includes/headerLoggedinDiffStyle.php';
        if($_SESSION['permissionType'] !== "A") {
          header("Location: index.php");
        }
?>

<div id="page-container">
    <div id="content-wrap">
        <h1 class="h1Home">Add Time Slots</h1>
        <p>Back To Admin Options
            <a href="../admin.php">Here</a>
        </p>
        <form action="../includes/addTimeSlots-inc.php" method="post">
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