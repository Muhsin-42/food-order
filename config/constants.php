<?php
    // start session
    session_start();

    // difine is the keyword to create onstant variable
    define('HOME_SITE','http://localhost/Projects/food_order/');
    define('LOCALHOST','localhost');
    define('DB_USERNAME','root');
    define('DB_PASSWORD','');
    define('DB_NAME','food-order');

    $conn = mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
    $err = mysqli_connect_error();
    if(!$conn)
        echo "Error : ".mysqli_connect_error();
?>