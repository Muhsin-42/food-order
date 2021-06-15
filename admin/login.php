<?php include("../config/constants.php") ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Food order</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="login">
        <h1 class="text-center">Login</h1>
        <!-- Login Error display -->
        <?php
            if(isset($_SESSION['login_msg']))
            {
                echo $_SESSION['login_msg'];
                unset($_SESSION['login_msg']);
            }
        ?>
        <!-- Login Error display -->
        <form action="" method="post" class="text-center">
            <br>     Username : <br> <input type="text" name="username" placeholder="Enter your username">
            <br><br> Password : <br> <input type="password" name="password" placeholder="Enter your password">
            <br><br><input type="submit" value="LOGIN"  name="submit">
        </form>
    </div>
</body>
</html>


<?php
    if(isset($_POST['submit']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $sql = "SELECT * FROM tbl_admin where username = '$username'";
        $result = mysqli_query($conn,$sql);
        $num_of_rows = mysqli_num_rows($result);
        
        if($num_of_rows==1)
        {
            $row = mysqli_fetch_assoc($result);

            if(password_verify($password,$row['password']))
            {
                $_SESSION['user'] = $username;
                $_SESSION['login_msg'] = "<div class='sucess text-center'>Welcome $_SESSION[user]</div>";
                header("location: index.php");

            }
            else
            {
                $_SESSION['login_msg'] = "<div class='error text-center'> Username and Password Dosent match!!</div>";
                header("location: login.php");
            }
            
        }
        else{
            $_SESSION['login_msg'] = "<div class='error text-center'> Username Dosen't exist!!</div>";
            header("location: login.php");
        }

    }
?>