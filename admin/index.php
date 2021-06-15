<?php include("partials/menu.php"); ?>
    <!-- main content start -->
    <div class="main">
        <div class="wrapper">
            <h1>DASHBOARD</h1>
            <!-- Login Message -->
            <?php
                if(isset($_SESSION['login_msg']))
                {
                    echo $_SESSION['login_msg'];
                    unset($_SESSION['login_msg']);
                }

                // Number of Categories
                $sql = "SELECT  count(*) FROM tbl_category";
                $result = mysqli_query($conn,$sql);
                $row = mysqli_fetch_assoc($result);
                $num_of_cat = $row['count(*)'];

                // Number of food
                $sql = "SELECT  count(*) FROM tbl_food";
                $result = mysqli_query($conn,$sql);
                $row = mysqli_fetch_assoc($result);
                $num_of_food = $row['count(*)'];

                // Number of orders
                $sql = "SELECT  count(*) FROM tbl_order";
                $result = mysqli_query($conn,$sql);
                $row = mysqli_fetch_assoc($result);
                $num_of_order = $row['count(*)'];

                // Total earnings
                $sql = "SELECT  sum(total) FROM tbl_order";
                $result = mysqli_query($conn,$sql);
                $row = mysqli_fetch_assoc($result);
                $total_earning = $row['sum(total)'];


            ?>
            <!-- Login Message -->
            <div class="col-4 text-center">
                <h1><?php echo $num_of_cat ?></h1>
                <p>categories</p>
            </div>
            <div class="col-4 text-center">
                <h1><?php echo $num_of_food ?></h1>
                <p>Foods</p>
            </div>
            <div class="col-4 text-center">
                <h1><?php echo $num_of_order ?></h1>
                <p>Total Orders</p>
            </div>
            <div class="col-4 text-center">
                <h1><?php echo "$",$total_earning ?></h1>
                <p>Earnings</p>
            </div>
            <div class="clear-both"></div>
        </div>
    </div>
    <!-- menu content end -->



    <?php include "partials/footer.php" ?>