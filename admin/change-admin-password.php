<?php include("partials/menu.php") ?>

<?php
    if(!isset($_GET['aid']))    //prevents direct url access 
    {
        header("location: manage-category.php");
    }
?>

<div class="main">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br>
        <?php
            if(isset($_SESSION['action_status']))
            {
                echo $_SESSION['action_status'];
                echo '<br>';
                unset($_SESSION['action_status']);
            }
        ?>
        <form action="" method="post">
            <table class="tbl-30">
                <tr>
                <?php
                        $id = $_GET['aid'];
                        $sql = "SELECT * FROM tbl_admin WHERE id = '$id'";
                        $result = mysqli_query($conn,$sql);
                        $row = mysqli_fetch_assoc($result);
                ?>
                <td>Old Password</td>
                    <td > <input type="password" name="old_password" placeholder="Old Password"   required> </td>
                    <td></td>
                </tr>
                <td>New Password</td>
                    <td > <input type="password" name="new_password1" placeholder="New Password"   required> </td>
                    <td></td>
                </tr>
                <td>Confirm Password</td>
                    <td > <input type="password" name="new_password2" placeholder="Confirm Password"   required> </td>
                    <td></td>
                </tr>
                <tr colspan="2">
                    <td > <input type="submit" value="CONFIRM PASSWORD" name="submit" class="btn-secondary"></td>
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
        $old_password = $_POST['old_password'];
        $new_password1 = $_POST['new_password1'];
        $new_password2 = $_POST['new_password2'];
        $id = $_GET['aid'];
        
        $password_error = false;
        if($new_password1==$new_password2)
        {
            $sql = "SELECT password from tbl_admin where id = '$id'";
            $result = mysqli_query($conn,$sql);
            
            if($result)
            {
                if (password_verify($old_password, $row['password']))
                {
                    $new_password1 = password_hash($new_password1,PASSWORD_DEFAULT);
                    $sql = "UPDATE `tbl_admin` SET 
                        `password` = '$new_password1' 
                        WHERE `id` = '$id';
                    ";
                    $p_result = mysqli_query($conn,$sql);
                    if($p_result){

                        $_SESSION['action_status'] = "<div class='sucess'>Password Changed sucessfully</div>";
                        header("location: manage-admin.php");
                    }else $password_error=true;
                }else $password_error = true;
            }else $password_error = true;
        } else $password_error =true;
        if($password_error)
        {
            $_SESSION['action_status'] = "<div class='error'>Failed to change password</div>";
            header("location: change-admin-password.php?aid=$id");
        }  
    }
?>