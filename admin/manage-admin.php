<?php include "partials/menu.php"; ?>
    <link rel="stylesheet" href="css/admin.css">
    <!-- main content start -->
    <div class="main">
        <div class="wrapper">
            <h1>Manage Admin</h1>

            <!-- button to add admin -->
            <br>

            <?php
                // to display action was sucess or not
                if(isset($_SESSION['action_status']))
                {
                    echo $_SESSION['action_status'];
                    echo "<br><br>";
                    unset($_SESSION['action_status']);
                }else echo '<br>';
            ?>
            <a href="add-admin.php" class="btn-primary">Add Admin</a><br><br>

            <table class="tbl-full">
                <tr>
                    <th>Sno</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>
                <?php
                    $sql ="SELECT * FROM tbl_admin";
                    $result = mysqli_query($conn,$sql);

                    $sno_counter = 1;
                    if($result)
                    {
                        $num_of_rows = mysqli_num_rows($result);
                        if($num_of_rows>0)
                        {

                            while($row = mysqli_fetch_assoc($result))
                            {
                                echo '
                                <tr>
                                <td>',$sno_counter++,'</td>
                                <td>',$row['full_name'],'</td>
                                <td>',$row['username'],'</td>
                                <td>
                                <a href="change-admin-password.php?aid=',$row['id'],'" class="btn-primary">Change Password</a>
                                <a href="edit-admin.php?aid=',$row['id'],'" class="btn-secondary">Edit</a>
                                <a href="delete-admin.php?aid=',$row['id'],'" class="btn-danger">Delete</a>
                                </td>
                                </tr>';
                            }
                        }
                        else{
                            echo "<td>No data to show</td>";
                        }
                    }
                ?>
            </table>
        </div>
    </div>

<?php include "partials/footer.php" ?>