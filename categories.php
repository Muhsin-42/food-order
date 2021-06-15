<?php include("partials-front/menu.php"); ?>


    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php
                $sql = "SELECT * from tbl_category WHERE active = 'YES' ";
                $result = mysqli_query($conn,$sql);

                while($row = mysqli_fetch_assoc($result))
                {
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];   
                    ?>
                    <a href="category-foods.php?cat_id=<?php echo $id ?>&cat_title=<?php echo $title ?>">
                    <div class="box-3 float-container">
                    <?php
                                if($image_name=="")
                                {
                                    echo "<br><br><br><br><br>";
                                    echo "Category Name : $title <br>";
                                    echo "Image not available";
                                }
                                else
                                {
                                    ?>    
                                    <img src="images/category/<?php echo $image_name ?>" alt="image not found" class="img-responsive img-curve" height="378px">
                                    <h3 class="float-text text-white"><?php echo $title ?></h3>
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

    <?php include("partials-front/footer.php"); ?>