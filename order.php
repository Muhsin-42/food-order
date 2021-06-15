<?php include("partials-front/menu.php"); ?>

<?php
    // Preventing direct access through the url
    if(!isset($_GET['f_id']))
    {
        header("location: index.php");
    }


    // Getting data
    $food_id = $_GET['f_id'];
    $sql = "SELECT *FROM tbl_food WHERE id = '$food_id'";
    $result = mysqli_query($conn,$sql);
    $num_of_rows = mysqli_num_rows($result);
    if($num_of_rows == 0)
        header("location: index.php");
    $row = mysqli_fetch_assoc($result);
    $food_title = $row['title'];
    $price = $row['price'];
    $food_image_name = $row['image_name'];
?>

    <!-- Food order form Starts  -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" class="order" method="POST">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">
                        <img src="images/food/<?php echo $food_image_name ?>" alt="image not found" class="img-responsive img-curve" style="max-height: 73px;">
                    </div>
    
                    <div class="food-menu-desc">
                        <h3><?php echo $food_title ?></h3>
                        <p class="food-price">$<?php echo $price ?></p>

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" min="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Muhsin nissar" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 9457xxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. example@gmail.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, State" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>

        </div>
    </section>
    <!-- Food order form ends-->

    <?php include("partials-front/footer.php"); ?>




<?php
    if(isset($_POST['submit']))
    {
        $quantity = $_POST['qty'];
        $cust_name = $_POST['full-name'];
        $cust_contact = $_POST['contact'];
        $cust_email = $_POST['email'];
        $cust_address = $_POST['address'];

        $total = $quantity*$price;
        $order_date = date('Y-m-d h:i:sa');
        $status = "ordered";

        $sql = "INSERT INTO tbl_order SET
                    food = '$food_title',
                    price = '$price',
                    qty = '$quantity',
                    total = '$total',
                    status = '$status',
                    cust_name = '$cust_name',
                    cust_contact = '$cust_contact',
                    cust_email = '$cust_email',
                    cust_address = '$cust_address'
                ";
        $result = mysqli_query($conn,$sql);

        if($result)
        {
            $_SESSION['order_stauts'] = '<div class="sucess text-center">Order placed sucessfully!</div>';
            // header('location: index.php');

            ?>
            <script>
                location.replace("index.php")
            </script>
            <?php
        }
        else 
        {
            $_SESSION['order_stauts'] = '<div class="error text-center">Failed to place oreder!</div>';
            // header('location: index.php');  
            ?>
            <script>
                location.replace("index.php")
            </script>
            <?php   
        }
    }
?>


<!-- INSERT INTO `tbl_order` 
(`food`, `price`, `qty`, `total`, `order_date`, `status`, `cust_name`, `cust_contact`, `cust_email`, `cust_address`)
 VALUES (
     'asdf', 
     '10',
      '1',
       '10',
        current_timestamp(),
         'ordered', 
         'man', 
         '1234567890',
          'man@gmail.com', 
          0xdfffd); -->