<?php
    //makes sure user is logged on as admin
    if ($_SESSION['is_valid_admin'] == FALSE) {
        header("Location: zua-login.php");
    }
?>