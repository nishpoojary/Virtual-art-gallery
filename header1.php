<?php
// header.php

// Load connection (and tableExists definition) exactly once
require_once __DIR__ . '/connection.php';

// Start session if needed
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <!-- Brand -->
        <div class="navbar-header">
            <a class="navbar-brand" href="products.php">The Indian Art Gallery</a>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <!-- Links -->
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                <?php if (!isset($_SESSION['id'])): ?>
                    <li><a href="signup.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                    <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                <?php else:
                    $user_id    = $_SESSION['id'];
                    $is_admin   = !empty($_SESSION['is_admin']);
                    $cart_count = 0;

                    // Only attempt to count if the table actually exists
                    if (function_exists('tableExists') && tableExists($con, 'users_items')) {
                        try {
                            $cart_res = mysqli_query(
                                $con,
                                "SELECT * FROM users_items WHERE user_id='$user_id' AND status='Added to cart'"
                            );
                            $cart_count = $cart_res ? mysqli_num_rows($cart_res) : 0;
                        } catch (\mysqli_sql_exception $e) {
                            // If anything goes wrong, default to zero
                            $cart_count = 0;
                        }
                    }
                ?>
                    <?php if (!$is_admin): // Show to normal users ?>
                        <li>
                            <a href="add_artwork.php">
                                <span class="glyphicon glyphicon-plus"></span>
                                Add Artwork
                            </a>
                        </li>
                    <?php endif; ?>

                    <li>
                        <a href="cart.php">
                            <span class="glyphicon glyphicon-shopping-cart"></span>
                            wishlist <span class="badge"><?php echo $cart_count; ?></span>
                        </a>
                    </li>
                    <li><a href="settings.php"><span class="glyphicon glyphicon-cog"></span> Home</a></li>
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
