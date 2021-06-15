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



<!-- Display order sucess or error message-->
<?php
    if(isset($_SESSION['order_stauts']))
    {
        echo $_SESSION['order_stauts'];
        unset($_SESSION['order_stauts']);
    }
?>

<!-- Display order sucess or error message -->




    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>


            <?php
                $sql = "SELECT * from tbl_category WHERE featured = 'YES' and active = 'YES' LIMIT 3";
                $result = mysqli_query($conn,$sql);
                if(!$result)    echo "ERror : ".mysqli_error($conn);
                else "sucess";
                while($row = mysqli_fetch_assoc($result))
                {
                    $cat_id = $row['id'];
                    $cat_title = $row['title'];
                    $cat_image_name = $row['image_name'];                    
                    ?>
                       <a href="category-foods.php?cat_id=<?php echo $cat_id; ?>&cat_title=<?php echo $cat_title ?>">
                        <div class="box-3 float-container">
                            <?php
                                if($cat_image_name=="")
                                {
                                    echo "<br><br><br><br><br>";
                                    echo "Category Name : $cat_title <br>";
                                    echo "Image not available";
                                }
                                else
                                {
                                    ?>    
                                    <img src="images/category/<?php echo $cat_image_name ?>" alt="Pizza" class="img-responsive img-curve" height="378px">
                                    <h3 class="float-text text-white"><?php echo $cat_title ?></h3>
                                    <?php
                                }
                            ?>
                        </div>
                        </a>
                    <?php
                }
            ?>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
            $sql = "SELECT * from tbl_food WHERE active = 'YES' and featured='YES' LIMIT 6";
            $result = mysqli_query($conn,$sql);

            while($row = mysqli_fetch_assoc($result))
            {
                $food_id = $row['id'];
                $food_title = $row['title'];
                $description = $row['description'];
                $food_image_name = $row['image_name'];
                $price = $row['price'];
                ?>    
    
                <div class="food-menu-box">
                    <div class="food-menu-img">
                        <img src="images/food/<?php echo $food_image_name ?>" alt="Image not found" class="img-responsive img-curve" height="93px">
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

        <p class="text-center">
            <a href="foods.php">See All Foods</a>
        </p>
    </section>
    <!-- fOOD Menu Section Ends Here -->

 <?php include("partials-front/footer.php"); ?>