<?php include("partials/menu.php") ?>

<?php
    // To prevent direct access to this site ie, without the aid value
    if(!isset($_GET['aid']))
    {
        header("location: manage-admin.php");
    }
?>

<div class="main">
    <div class="wrapper">
        <h1>Edit Admin</h1>
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
                <?php
                        $id = $_GET['aid'];
                        $sql = "SELECT * FROM tbl_admin WHERE id = '$id'";
                        $result = mysqli_query($conn,$sql);
                        $row = mysqli_fetch_assoc($result);
                ?>
                    <td>Full Name</td>
                    <td > <input type="text" name="full_name" value="<?php echo $row['full_name'] ?>"  required> </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Username</td>
                    <td > <input type="text" name="username" value="<?php echo $row['username'] ?>" required> </td>
                    <td></td>
                </tr>
                <tr colspan="2">
                    <td > <input type="submit" value="Update Admin" name="submit" class="btn-secondary"></td>
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

        // insert data into Database
        $sql = "UPDATE `tbl_admin` SET 
                `full_name` = '$full_name', 
                `username` = '$username' 
                WHERE `id` = '$id';
                ";

        $result = mysqli_query($conn,$sql);
        
        if($result)
        {
            $_SESSION['action_status'] = "<div class='sucess'>Admin Updated sucessfully</div>";
            header("location: manage-admin.php");
        }
        else
        {
            $_SESSION['action_status'] = "<div class='error'>Failed to update admin</div>";
            header("location: edit-admin.php?aid=$id.php");
        }
       
    }
    
?>