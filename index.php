<?php
    session_start();
    
    if(isset($_SESSION['message'])){
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
    if(!isset($_SESSION['user'])){
        $_SESSION['message'] = "Please Register";
        header('Location: register.php');
    }
    $db = mysqli_connect('localhost','smlprj','','smlprj');
    if(!$db){
        die('Could not connect to database: '.mysqli_connect_error());
    }

?>