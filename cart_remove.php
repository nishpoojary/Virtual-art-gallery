<?php
// cart_remove.php

require_once __DIR__ . '/connection.php';
session_start();

// Must be logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

// Only handle POST removals
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id'])) {
    $user_id = intval($_SESSION['id']);
    $item_id = intval($_POST['item_id']);

    mysqli_query(
        $con,
        "DELETE FROM users_items
                WHERE user_id = $user_id
                  AND item_id = $item_id
                  AND status  = 'Added to cart'"
    );
}

// Redirect back to cart
header('Location: cart.php');
exit();
