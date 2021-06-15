<?php include("partials/menu.php") ?>

<div class="main">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br>
        <?php
            if(isset($_SESSION['action_status']))
            {
                echo $_SESSION['action_status'];
                echo '<br><br>';
                unset($_SESSION['action_status']);
            }
        ?>
        <form action="" method="post">
            <table class="tbl-30">
                <tr>
                    <td>Full Name</td>
                    <td > <input type="text" name="full_name" placeholder="Enter your name" required> </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Username</td>
                    <td > <input type="text" name="username" placeholder="Enter your Username" required> </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td > <input type="password" name="password" placeholder="Enter your Password" required> </td>
                    <td></td>
                </tr>
                <tr colspan="2">
                    <td > <input type="submit" value="Add Admin" name="submit" class="btn-secondary"></td>
                    <td></td>
                </tr>
            </table>
        </form>
    </div>
</div>




<?php include("partials/footer.php") ?>



<!-- PHP Section -->

<?php
    if(isset($_POST['submit']))
    {
        // Get data from form
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $password = password_hash($password,PASSWORD_DEFAULT);
        // insert data into Database
        $sql = "INSERT INTO tbl_admin SET  
                    full_name = '$full_name',
                    username = '$username',
                    password = '$password'
                ";

        $result = mysqli_query($conn,$sql);
        
        if($result)
        {
            $_SESSION['action_status'] = "<div class='sucess'>Admin added sucessfully</div>";
            header("location: manage-admin.php");
        }
        else
        {
            $_SESSION['action_status'] = "<div class='error'>Failed to add admin</div>";
            header("location: add-admin.php");
        }
       
    }
    
?>