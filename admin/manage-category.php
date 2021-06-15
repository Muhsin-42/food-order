<?php include("partials/menu.php") ?>

<div class="main">
    <div class="wrapper">
        <h1>Manage Category</h1>
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
            <a href="add-category.php" class="btn-primary">Add Categories</a><br><br>

            <table class="tbl-full">
                <tr>
                    <th>Sno</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
                <?php
                    $sql = "SELECT * FROM tbl_category";
                    $result = mysqli_query($conn,$sql);
                    $num_of_rows = mysqli_num_rows($result);
                    
                    if($num_of_rows==0)
                        echo "<td>No categories to show!!</td>";
                    $sno=1;
                    while($row = mysqli_fetch_assoc($result))
                    {
                        echo '
                        <tr>
                        <td>'.$sno++.'</td>
                        <td>'.$row['title'].'</td>
                        <td> <img src="../images/category/'.$row['image_name'].'" alt="Image Not found" width=50px > </td>
                        <td>'.$row['featured'].'</td>
                        <td>'.$row['active'].'</td>
                        <td>
                            <a href="edit-category.php?cat_id=',$row['id'],'" class="btn-secondary">Edit</a>
                            <a href="delete-category.php?cat_id=',$row['id'],',img=',$row['image_name'],'" class="btn-danger">Delete</a>
                        </td>
                    </tr>
                        ';
                    }
                ?>
            </table>
    </div>
</div>

<?php include("partials/footer.php") ?>