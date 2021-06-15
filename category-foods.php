<?php include("partials-front/menu.php"); ?>

<!-- Prevent direct access through URL -->
<?php
    if(!isset($_GET['cat_id']) or !isset($_GET['cat_title']))
    {
        header("location: index.php");
    }


    $cat_id = $_GET['cat_id'];
    $cat_title = $_GET['cat_title'];
    $sql = "SELECT * from tbl_food WHERE active = 'YES' and cat_id = '$cat_id' ";
    $result = mysqli_query($conn,$sql);
?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <h2>Foods on <a href="#" class="text-white"><h3 style="display: inline;">"<?php echo $cat_title ?> "</h3></a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php

            $num_rows = mysqli_num_rows($result);
            if($num_rows == 0)
                echo "<div class='text-center text-light-black'>No $cat_title available right now!</div>";
            while($row = mysqli_fetch_assoc($result))
            {
                $food_id = $row['id'];
                $title = $row['title'];
                $description = $row['description'];
                $image_name = $row['image_name'];
                $price = $row['price'];
                ?>    
    
                <div class="food-menu-box">
                    <div class="food-menu-img">
                        <img src="images/food/<?php echo $image_name ?>" alt="image not found" class="img-responsive img-curve" style="max-height:72px">
                    </div>

                    <div class="food-menu-desc">
                        <h4><?php echo $title ?></h4>
                        <p class="food-price">$<?php echo $price ?></p>
                        <p class="food-detail">
                        <?php echo substr($description,0,18) ?>
                        </p>
                        <br>
                        <a href="order.php?f_id=<?php echo $food_id ?>" class="btn btn-primary">Order Now</a>
                    </div>
                </div>
                <?php
            }
        ?>



            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include("partials-front/footer.php"); ?>