<?php
// delete_artwork.php

require_once __DIR__ .'/connection.php';
session_start();

// Only allow admins
if (empty($_SESSION['id']) || empty($_SESSION['is_admin'])) {
    header('Location: login.php');
    exit();
}

// Validate and cast the incoming ID
if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
    header('Location: admin.php');
    exit();
}
$item_id = (int)$_GET['id'];

// Perform deletion
$query = "DELETE FROM items WHERE id = $item_id";
if (!mysqli_query($con, $query)) {
    // On error, you might log or show a friendly message
    error_log("Failed to delete item $item_id: " . mysqli_error($con));
}

// Redirect back to the dashboard
header('Location: admin.php');
exit();
