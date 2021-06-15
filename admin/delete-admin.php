<?php
    include("../config/constants.php");

    //To prevent direct url access
    if(!isset($_GET['cat_id']))    
    {
        header("location: manage-category.php");
    }
    $id = $_GET['aid'];

    $sql = "DELETE FROM `tbl_admin` WHERE id = '$id'";
    $r = mysqli_query($conn,$sql);
    if($r)
    {
        $_SESSION['action_status'] = '<div class="sucess">Admin deleted sucessfully </div>';
    }
    else
    {
        $_SESSION['action_status'] = '<div class="error">Failed to deleted Admin</div>';
    }
    header("location: manage-admin.php");
?>