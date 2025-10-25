<?php
// connection.php

// Show all errors for development (remove or lower in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Only establish the connection once
if (!isset($con) || !($con instanceof mysqli)) {
    $con = new mysqli("localhost", "root", "nishmitha", "store");

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    // Ensure proper encoding
    $con->set_charset("utf8mb4");

    // Turn on mysqli exceptions for errors
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    // ── Migration / setup code ──

    // Declare tableExists() only if it doesn't already exist
    if (!function_exists('tableExists')) {
        /**
         * Check if a table exists in the current database.
         *
         * @param mysqli $con
         * @param string $table
         * @return bool
         */
        function tableExists(mysqli $con, string $table): bool {
            $tbl = mysqli_real_escape_string($con, $table);
            $res = $con->query("SHOW TABLES LIKE '$tbl'");
            return $res && $res->num_rows > 0;
        }
    }

    // Example migration: add user_id column & FK if missing
    if (tableExists($con, 'items')) {
        $colCheck = $con->query("SHOW COLUMNS FROM `items` LIKE 'user_id'");
        if ($colCheck && $colCheck->num_rows === 0) {
            $alter = "ALTER TABLE `items` ADD COLUMN `user_id` INT NOT NULL";
            if (!$con->query($alter)) {
                die("Error adding user_id column: " . $con->error);
            }
            $fk = "ALTER TABLE `items` ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)";
            if (!$con->query($fk)) {
                die("Error adding foreign key: " . $con->error);
            }
        }
    }

    // ── End migration / setup ──
}
