<?php
    session_start();

    echo $_SESSION['message'];
    //unset($_SESSION['message']);
?>