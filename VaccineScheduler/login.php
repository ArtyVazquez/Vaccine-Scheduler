<?php
    require_once 'includes/header.php';
  ?>

<div id="page-container">
    <div id="content-wrap">
        <h1 class="h1Home">LOGIN</h1>
        <div class="login">
            <p>No account?
                <a href="register.php">REGISTER HERE!</a>
            </p>
            <form action="includes/login-inc.php" method="post">
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
                
                <select class="choose" name="permissionType">
                    <option value="" disabled selected>Type</option>  
                    <option value="A">Admin</option>
                    <option value="P">Patient</option>
                    <option value="N">Nurse</option>
                </select>


                <button type="submit" name='submit'>LOGIN</button>
            </form>
        </div>
    </div>
    <footer id="footer">
        <p class="pF">UI Health Covid Vaccination Database. Designed by Arturo Vazquez.
        </p>
    </footer>
</div>
</body>
</html>