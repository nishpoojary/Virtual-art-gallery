<?php
// check_if_added.php

/**
 * Returns true if the given item is already in the current user's cart.
 */
function check_if_added_to_cart(int $item_id): bool {
    // We assume connection.php has already been required and session started
    global $con;
    if (!isset($_SESSION['id'])) {
        return false;
    }
    $user_id = $_SESSION['id'];
    $item_id = mysqli_real_escape_string($con, (string)$item_id);
    $res = mysqli_query($con, "
        SELECT * 
        FROM users_items 
        WHERE user_id='$user_id' 
          AND item_id='$item_id' 
          AND status='Added to cart'
    ");
    return $res && mysqli_num_rows($res) > 0;
}
