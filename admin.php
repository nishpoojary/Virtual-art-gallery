<?php
// admin.php

require_once __DIR__ . '/connection.php';
session_start();

// Only allow admins
if (empty($_SESSION['id']) || empty($_SESSION['is_admin'])) {
    header('Location: login.php');
    exit();
}

// Fetch admin info
$admin_id = (int)$_SESSION['id'];
$admQ     = "
    SELECT aid AS id, email
    FROM admin
    WHERE aid = $admin_id
    LIMIT 1
";
$admR = mysqli_query($con, $admQ);
if (!$admR || mysqli_num_rows($admR) !== 1) {
    die('Admin account not found.');
}
$admin = mysqli_fetch_assoc($admR);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard — The Indian Art Gallery</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="bootstrap/js/jquery-3.2.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
    <?php require_once __DIR__ . '/header1.php'; ?>

    <div class="container" style="padding-top:80px;">
        <h2>Admin Dashboard</h2>
        <p>Welcome, <strong><?php echo htmlspecialchars($admin['email']); ?></strong></p>

        <!-- Your admin controls here -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Manage Artworks</h3>
            </div>
            <div class="panel-body">
                <a href="add_artwork.php" class="btn btn-success">Add New Artwork</a>
                <hr>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr><th>ID</th><th>Name</th><th>Price</th><th>Actions</th></tr>
                        </thead>
                        <tbody>
                        <?php
                        $itmQ = "SELECT id, name, price FROM items ORDER BY id DESC";
                        $itmR = mysqli_query($con, $itmQ);
                        while ($it = mysqli_fetch_assoc($itmR)): ?>
                            <tr>
                                <td><?php echo $it['id']; ?></td>
                                <td><?php echo htmlspecialchars($it['name']); ?></td>
                                <td>₹<?php echo number_format($it['price'],2); ?></td>
                                <td>
                                    <a href="edit_artwork.php?id=<?php echo $it['id']; ?>"
                                       class="btn btn-sm btn-primary">Edit</a>
                                    <a href="delete_artwork.php?id=<?php echo $it['id']; ?>"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Delete this artwork?');">
                                       Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer" style="margin-top:40px;">
        <div class="container">
            <center>
                <p>
                    Showcase your talent at The Indian Art Gallery.&nbsp;
                    Contact us at <a href="mailto:art@artgallery.com">art@artgallery.com</a>
                </p>
            </center>
        </div>
    </footer>
</body>
</html>
