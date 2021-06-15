<?php include("partials/menu.php") ?>

<?php
    // redirect to manage-food page if get values are not passed
    if(!isset($_GET['f_id']))
    {
        header("location: manage-food.php");
        die();
    }

    // Getting currrent values
    $id = $_GET['f_id'];
    $sql = "SELECT * FROM tbl_food WHERE id = '$id'";
    $result = mysqli_query($conn,$sql);

    $row = mysqli_fetch_assoc($result);
    $title = $row['title'];
    $description = $row['description'];
    $category_id = $row['cat_id'];
    $price= $row['price'];
    $old_image_name = $row['image_name'];
    $featured = $row['featured'];
    $active = $row['active'];
    
?>

<div class="main">
    <div class="wrapper">
        <h1>Edit Food</h1>
        <br>
        <?php
            if(isset($_SESSION['action_status']))
            {
                echo '<br>';
                echo $_SESSION['action_status'];
                echo '<br>';
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
                    <td>Description: </td>
                    <td > <textarea name="description" cols="20" rows="6" ><?php echo $description ?></textarea> </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Price : </td>
                    <td > <input type="number" min="0" step="0.01" name="price" value="<?php echo $price ?>" required> </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Current Image : </td>
                    <td > <img src="../images/food/<?php echo $old_image_name ?>" alt="No image found" width="100px" class="error"> </td>
                    <td></td>
                </tr>
                <tr>
                    <td> New Image : </td>
                    <td > <input type="file" name="image" value="<?php echo "image" ?>"> </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Category : </td>
                    <td > 
                        <select name="category" id="">
                            <?php
                                $sql = "SELECT * FROM tbl_category";
                                $result = mysqli_query($conn,$sql);
                                if(mysqli_num_rows($result)>0)
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        // echo '<option value="'.$row['id'].'" >'.$row['title'].'</option>';
                                        ?>
                                            <option value="<?php echo $row['id']?>" <?php if($category_id==$row['id']){ echo "selected";} ?> > <?php echo $row['title']?> </option>
                                        <?php
                                    }
                                else echo "<option value='1'>No categories found</option>";
                                ?>
                                
                            </select>
                    </td>
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
                    <td > <input type="submit" value="Update Food" name="submit" class="btn-secondary"></td>
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
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category_id = $_POST['category'];
        $featured= $_POST['featured'];
        $active = $_POST['active'];

        // ===========================
        // working with selected image
        // ===========================
            $img_name = $_FILES['image']['name'];
            if($img_name !="")
            {
                unlink("../images/food/".$old_image_name); //delets image from category folder 
                // extract Extention
                $ext = end(explode('.',$img_name)); //explode()- to split || end()-gets the last ele of the array ie the extension
                
                // validating the extension
                $allowed_ext = array('png','jpg','gif','img','svg');
                if(!in_array($ext,$allowed_ext))
                {
                    $_SESSION['action_status']= "<div class='error'> Invalid image type!! </div>";
                    header("location: edit-food.php");
                    die();
                }
                //Renaming image
                $img_name = str_replace(" ","_",$title).rand(000,9999).'.'.$ext;
                
                // getting other info of image
                $img_src_path = $_FILES['image']['tmp_name'];
                $img_dest_path =  "../images/food/".$img_name;
                
                // Uploading image in Folder
                $upload = move_uploaded_file($img_src_path,$img_dest_path);
                if(!$upload)
                {
                    $_SESSION['action_status'] = "<div class='error'>Error while uploading image </div>";
                    header("location: edit-food.php");
                    die();
                }
                
                $sql = "UPDATE tbl_food SET
                    title = '$title',
                    description = '$description',
                    image_name = '$img_name',
                    cat_id = '$category_id',
                    featured = '$featured',
                    active = '$active',
                    price = '$price'
                    where id = '$id'
                ";

                $result = mysqli_query($conn,$sql);

                if($result)
                {
                    $_SESSION['action_status'] = "<div class='sucess'>Food updated sucessfully</div>";

                    // header("location: manage-food.php");-
                    ?>
                    <script>
                        location.replace("manage-food.php")
                    </script>
                    <?php
                }
                else
                {
                    // echo "Error : ".mysqli_error($conn);
                    $_SESSION['action_status'] = "<div class='error'>1Failed to update Food</div>";
                    header("location: edit-food.php");
                }  
            }
            else
            {
                $sql = "UPDATE tbl_food SET
                    title = '$title',
                    description = '$description',
                    cat_id = '$category_id',
                    featured = '$featured',
                    active = '$active',
                    price = '$price'
                    where id = '$id'
                ";

                $result = mysqli_query($conn,$sql);

                if($result)
                {
                    $_SESSION['action_status'] = "<div class='sucess'>Food updated sucessfully</div>";

                    // THE HEADER IS NOT WORKING SO I USED JAVASCRIPT TO REDIRECT 
                    ?>
                    <script>
                        location.replace("manage-food.php")
                    </script>
                    <?php
                }
                else
                {
                    $_SESSION['action_status'] = "<div class='error'>1Failed to update Food</div>";
                    header("location: edit-food.php");
                }
            }
    }
?>