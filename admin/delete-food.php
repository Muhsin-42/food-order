<!-- 100%  Completed -->

<!-- Future addition 
        * Confirm Before Delete -->


<?php
    include("../config/constants.php");

    if(isset($_GET['f_id']))
    {
        $id = $_GET['f_id'];
        
        // get image name to delete it from stored folder
        $sql = "SELECT *FROM `tbl_food` WHERE id = '$id'";
        $result = mysqli_query($conn,$sql);
        $row= mysqli_fetch_assoc($result);
        $img_name = $row['image_name'];
        unlink("../images/food/".$img_name); //delets image from category folder 

        // Delete row from Database`
        $sql = "DELETE FROM `tbl_food` WHERE id = '$id'";
        $result = mysqli_query($conn,$sql);
        
        if($result)     $_SESSION['action_status'] = '<div class="sucess">Food deleted sucessfully </div>';
        else            $_SESSION['action_status'] = '<div class="error">Failed to delete Food!!</div>';

        header("location: manage-food.php");
    }
    else    header("location: manage-food.php");
?>
