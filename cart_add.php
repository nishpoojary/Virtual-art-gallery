<?php
// cart_add.php

require_once __DIR__ . '/connection.php';
session_start();

// must be logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

// only on POST with item_id
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['item_id'])) {
    $user_id = (int)$_SESSION['id'];
    // ensure integer
    $item_id = (int)$_POST['item_id'];

    // prevent duplicate
    $exists = mysqli_query(
        $con,
        "SELECT 1 
           FROM users_items 
          WHERE user_id=$user_id 
            AND item_id=$item_id 
            AND status='Added to cart'"
    );
    if (mysqli_num_rows($exists) === 0) {
        mysqli_query(
            $con,
            "INSERT INTO users_items 
                (user_id, item_id, status) 
             VALUES 
                ($user_id, $item_id, 'Added to cart')"
        );
    }
}

// redirect to cart
header('Location: cart.php');
exit();
