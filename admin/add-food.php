<?php include("partials/menu.php") ?>

<div class="main">
    <div class="wrapper">
        <h1>Add Food</h1>
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
                    <td > <input type="text" name="title" placeholder="Food title" required> </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td > <textarea name="description" id="" cols="20" rows="6" ></textarea> </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Price : </td>
                    <td > <input type="number" min="0" step="0.01" name="price" placeholder="Price in USD" required> </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Image : </td>
                    <td > <input type="file" name="image" placeholder="Chose file"> </td>
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
                                        echo '<option value="'.$row['id'].'">'.$row['title'].'</option>';
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
                        <input type="radio" name="featured" value="YES" required>Yes 
                        <input type="radio" name="featured" value="NO" required> No
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Active : </td>
                    <td > 
                        <input type="radio" name="active" value="YES" required>Yes
                        <input type="radio" name="active" value="NO" required> No
                    </td>
                    <td></td>
                </tr>


                <tr colspan="2">
                    <td > <input type="submit" value="Add Food" name="submit" class="btn-secondary"></td>
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

        // ========================================================
        // working with selected image
            $image = $_FILES['image'];
            $img_name = $_FILES['image']['name'];
            // check whether the image is selected or not
            if($img_name !="")
            {
                // extract Extention
                $ext = end(explode('.',$img_name)); //explode()- to split || end()-gets the last ele of the array ie the extension
                
                // validating the extension
                $allowed_ext = array('png','jpg','gif','img','svg');
                if(!in_array($ext,$allowed_ext))
                {
                    $_SESSION['action_status']= "<div class='error'> Invalid image type!! </div>";
                    header("location: add-food.php");
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
                    header("location: add-food.php");
                    die();
                }
            }
        // ======================================================


        // Insert into DataBase
        $sql = "INSERT INTO tbl_food SET
                    title = '$title',
                    description = '$description',
                    image_name = '$img_name',
                    cat_id = '$category_id',
                    featured = '$featured',
                    active = '$active',
                    price = '$price'
                ";

        $result = mysqli_query($conn,$sql);
        
        if($result) //if Insertion Sucess
        {
            $_SESSION['action_status'] = "<div class='sucess'>Food added sucessfully</div>";
            header("location: manage-food.php");
        }
        else    //If Insertion failure
        {
            echo "Error : ".mysqli_error($conn);
            $_SESSION['action_status'] = "<div class='error'>Failed to add Food</div>";
            // header("location: add-food.php");
        }  
    }
?>