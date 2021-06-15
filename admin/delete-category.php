<?php
    include("../config/constants.php");

    if(isset($_GET['cat_id']))
    {
        $id = $_GET['cat_id'];
        
        // get image name to delete it from stored folder
        $sql = "SELECT *FROM `tbl_category` WHERE id = '$id'";
        $result = mysqli_query($conn,$sql);
        $row= mysqli_fetch_assoc($result);
        $img_name = $row['image_name'];
        unlink("../images/category/".$img_name); //delets image from category folder 

        // Delete row from Database`
        $sql = "DELETE FROM `tbl_category` WHERE id = '$id'";
        $result = mysqli_query($conn,$sql);
        
        if($result)     $_SESSION['action_status'] = '<div class="sucess">Category deleted sucessfully </div>';
        else            $_SESSION['action_status'] = '<div class="error">Failed to delete Category</div>';

        header("location: manage-category.php");
    }
    else    header("location: manage-category.php");
?>