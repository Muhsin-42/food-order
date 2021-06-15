<?php include("partials/menu.php") ?>

<!-- Getting old data -->
<?php
    $id = $_GET['cat_id'];

    if(!isset($_GET['cat_id']))   //prevents direct url access 
    {
        header("location: manage-category.php");
    }
    
    $sql = "SELECT *FROM tbl_category where id = '$id'";
    $result = mysqli_query($conn,$sql);

    $row = mysqli_fetch_assoc($result);
    $title = $row['title'];
    $old_image_name = $row['image_name'];
    $featured = $row['featured'];
    $active = $row['active'];
?>




<div class="main">
    <div class="wrapper">
        <h1>Edit Category</h1>
        <br>
        <?php
            if(isset($_SESSION['action_status']))
            {
                echo $_SESSION['action_status'];
                echo '<br><br>';
                unset($_SESSION['action_status']);
            }
        ?>
         <form action="" method="post" enctype="multipart/form-data"> <!-- enctype allows to upload files-->
            <table class="tbl-30">
                <tr>
                    <td>Title : </td>
                    <td > <input type="text" name="title" value="<?php echo $title ?>" required> </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Current Image : </td>
                    <td > <img src="../images/category/<?php echo $old_image_name ?>" alt="" width="100px"> </td>
                    <td></td>
                </tr>
                <tr>
                    <td> New Image : </td>
                    <td > <input type="file" name="image" value="<?php echo "image" ?>"> </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Featured : </td>
                    <td > 
                        <input type="radio" name="featured" value="YES" required <?php if($featured=="YES"){ echo "checked";} ?> >YES 
                        <input type="radio" name="featured" value="NO" required <?php if($featured=="NO"){ echo "checked";} ?> > NO
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Active : </td>
                    <td > 
                        <input type="radio" name="active" id="yes" value="YES" required <?php if($active=="YES"){ echo "checked";} ?>>YES 
                        <input type="radio" name="active" id="no" value="NO" required <?php if($active=="NO"){ echo "checked";} ?>> NO
                    </td>
                    <td></td>
                </tr>
                <tr colspan="2">
                    <td > <input type="submit" value="Update Category" name="submit" class="btn-secondary"></td>
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
        $title = $_POST['title'];
        $featured = $_POST['featured'];
        $active = $_POST['active'];

        // ===========================
        // working with selected image
        // ===========================
            $img_name = $_FILES['image']['name'];
            if($img_name !="")
            {
                unlink("../images/category/".$old_image_name); //delets image from category folder 
                // extract Extention
                $ext = end(explode('.',$img_name)); //explode()- to split || end()-gets the last ele of the array ie the extension
                
                // validating the extension
                $allowed_ext = array('png','jpg','gif','img','svg');
                if(!in_array($ext,$allowed_ext))
                {
                    $_SESSION['action_status']= "<div class='error'> Invalid image type!! </div>";
                    header("location: edit-category.php");
                    die();
                }
                //Renaming image
                $img_name = str_replace(" ","_",$title).rand(000,9999).'.'.$ext;
                
                // getting other info of image
                $img_src_path = $_FILES['image']['tmp_name'];
                $img_dest_path =  "../images/category/".$img_name;
                
                // Uploading image in Folder
                $upload = move_uploaded_file($img_src_path,$img_dest_path);
                if(!$upload)
                {
                    $_SESSION['action_status'] = "<div class='error'>Error while uploading image </div>";
                    header("location: edit-category.php");
                    die();
                }
                
                $sql = "UPDATE tbl_category SET
                    title = '$title',
                    image_name = '$img_name',
                    featured = '$featured',
                    active = '$active'
                    where id = '$id'
                ";

                $result = mysqli_query($conn,$sql);

                if($result)
                {
                    $_SESSION['action_status'] = "<div class='sucess'>Category updated sucessfully</div>";
                    header("location: manage-category.php");
                }
                else
                {
                    $_SESSION['action_status'] = "<div class='error'>1 Failed to update Category</div>";
                    header("location: edit-category.php");
                }  
            }
            else
            {
                $sql = "UPDATE tbl_category SET
                    title = '$title',
                    featured = '$featured',
                    active = '$active'
                    where id = '$id'
                ";

                $result = mysqli_query($conn,$sql);

                if($result)
                {
                    $_SESSION['action_status'] = "<div class='sucess'>Category updated sucessfully</div>";
                    header("location: manage-category.php");
                }
                else
                {
                    $_SESSION['action_status'] = "<div class='error'>2 Failed to update Category</div>";
                    header("location: edit-category.php");
                }
            }
    }
?>