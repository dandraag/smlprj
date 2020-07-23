<?php
    session_start();
    
    if(isset($_SESSION['message'])){
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }

    $db = mysqli_connect('localhost','smlprj','','smlprj');
    if(!$db){
        die('Could not connect to database: '.mysqli_connect_error());
    }

    if(isset($_SESSION['user'])){
        $_SESSION['message'] = "Already Logged in";
        header('Location: index.php');
    }

    $err = array();
    $err['uname'] = '';
    $err['pass'] = '';

    $username = "";
    $e = 0;

    if(isset($_POST['reg'])){
        if(!$username=$_POST['uname']){
            $err['uname'] = 'Please enter username';
            $e++;
        }
        if(!$password1 = $_POST['pass']){
            $err['pass'] = 'Please enter password';
            $e++;
        }
        if($e==0){            
            $login_query = "SELECT uid,isadmin FROM users WHERE uname='$username'";
            if($_SESSION['user'] = mysqli_fetch_assoc(mysqli_query($db,$login_query))){
                $_SESSION['message'] = "Login Successful!";
                header('Location: index.php');
            }
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login Here!</title>
    </head>
    <body>
        <form action="login.php" method="POST">
            <label for="uname">Name: </label><br>
            <input type="text" id="uname" name="uname" value=<?php echo $username?>><?php echo $err['uname']?><br>
            <label for="pass1">Password: </label><br>
            <input type="password" id="pass" name="pass"><?php echo $err['pass']?><br>
            <input type="submit" name="reg" value="Login">
        </form>
    </body>
</html>