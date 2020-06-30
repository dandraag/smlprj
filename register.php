<?php
    session_start();

    $db = mysqli_connect('localhost','smlprj','','smlprj');
    if(!$db){
        die('Could not connect to database: '.mysqli_connect_error());
    }

    $err = array();
    $err['uname'] = '';
    $err['insti'] = '';
    $err['pass1'] = '';
    $err['pass2'] = '';

    $username = "";
    $insti = "";
    $e = 0;

    if(isset($_POST['reg'])){
        if(!$username=$_POST['uname']){
            $err['uname'] = 'Please enter username';
            $e++;
        }
        if(!$insti=$_POST['insti']){
            $err['insti'] = 'Please enter institute';
            $e++;
        }
        $password1 = $_POST['pass1'];
        $password2 = $_POST['pass2'];
        if(!$password1){
            $err['pass1'] = 'Please enter password';
            $e++;
        }
        if(!($password1==$password2)){
            $err['pass2'] = 'Passwords do not match';
            $e++;
        }

        if($e==0){
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
            $salt = substr(str_shuffle($permitted_chars),0,6);
            $pass = md5($password1.$salt);
            
            $reg_query = "INSERT INTO users(uname,insti,salt,password) VALUES ('$username','$insti','$salt','$pass')";

            if(mysqli_query($db,$reg_query)){
                echo "Registered";
                $uid_query = "SELECT * FROM users WHERE uname='$username'";
                $_SESSION['user'] = mysqli_fetch_assoc(mysqli_query($db,$uid_query));
                print_r($_SESSION);
                session_destroy();
            }
            else{
                echo "Error: ".$query."<br>".mysqli_error($db);
            }
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Register Here!</title>
    </head>
    <body>
        <form action="register.php" method="POST">
            <label for="uname">Name: </label><br>
            <input type="text" id="uname" name="uname" value=<?php echo $username?>><?php echo $err['uname']?><br>
            <label for="insti">Institute: </label><br>
            <input type="text" id="insti" name="insti" value=<?php echo $insti?>><?php echo $err['insti']?><br>
            <label for="pass1">Password: </label><br>
            <input type="password" id="pass1" name="pass1"><?php echo $err['pass1']?><br>
            <label for="pass2">Repeat Password: </label><br>
            <input type="password" id="pass2" name="pass2"><?php echo $err['pass2']?><br>
            <input type="submit" name="reg" value="Register">
        </form>
    </body>
</html>