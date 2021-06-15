<?php include("partials-front/menu.php"); ?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">

    <form action="food-search.php" method="POST">
                <input type="search" name="search_keyword" placeholder="Search for Food.." required>
                <input type="submit" name="search_submit" value="Search" class="btn btn-primary">
    </form>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->



<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>


        <?php
            $sql = "SELECT * from tbl_food WHERE active = 'YES' ";
            $result = mysqli_query($conn,$sql);

            while($row = mysqli_fetch_assoc($result))
            {
                $food_id = $row['id'];
                $food_title = $row['title'];
                $description = $row['description'];
                $image_name = $row['image_name'];
                $price = $row['price']
                ?>    
    
                <div class="food-menu-box">
                    <div class="food-menu-img">
                        <img src="images/food/<?php echo $image_name ?>" alt="image not found" class="img-responsive img-curve" style="max-height: 90px;" >
                    </div>

                    <div class="food-menu-desc">
                        <h4><?php echo $food_title ?></h4>
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