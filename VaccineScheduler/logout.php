<?php
    session_start();    
    session_destroy();
    echo "<script>
          alert('Successful logout');
          window.location.href='index.php';
          </script>";
?>