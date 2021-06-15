<?php include("partials/menu.php") ?>

<div class="main">
    <div class="wrapper">
        <h1>Manage Food</h1>
        <!-- Error or Sucess message -->
        <?php
            if(isset($_SESSION['action_status']))
            {
                echo "<br>";
                echo $_SESSION['action_status'];
                unset($_SESSION['action_status']);
            }
        ?>
        <!-- Error or Sucess message -->

        <!-- button to add admin -->
        <br><br>
            <a href="add-food.php" class="btn-primary">Add Food</a><br><br>

            <table class="tbl-full">
                <tr>
                    <th>Sno</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Category</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>Actions</th>

                </tr>
                <?php
                    $sql = "SELECT * FROM tbl_food";
                    $result = mysqli_query($conn,$sql);
                    $num_of_rows = mysqli_num_rows($result);
                    
                    if($num_of_rows==0)
                        echo "<td>No Foods to show!!</td>";
                    $sno=1;
                    while($row = mysqli_fetch_assoc($result))
                    {
                        $cat_name_sql = "SELECT title from tbl_category where id = '$row[cat_id]'"; 
                        $cat_name_result = mysqli_query($conn,$cat_name_sql);
                        $cat_name = mysqli_fetch_assoc($cat_name_result);

                        echo '
                        <tr>
                        <td>'.$sno++.'</td>
                        <td>'.$row['title'].'</td>
                        <td>'.substr($row['description'],0,17).'...</td>
                        <td>$'.$row['price'].'</td>
                        <td> <img src="../images/food/'.$row['image_name'].'" alt=" Not found" width=50px > </td>
                        <td>'.$cat_name['title'].'</td>
                        <td>'.$row['featured'].'</td>
                        <td>'.$row['active'].'</td>
                        <td>
                            <a href="edit-food.php?f_id=',$row['id'],'" class="btn-secondary">Edit</a>
                            <a href="delete-food.php?f_id=',$row['id'],',img=',$row['image_name'],'" class="btn-danger">Delete</a>
                        </td>
                    </tr>
                        ';
                    }
                ?>
            </table>
    </div>
</div>

<?php include("partials/footer.php") ?>