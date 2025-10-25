<?php
// edit_artwork.php

require_once __DIR__ . '/connection.php';
session_start();

// Only allow admins
if (empty($_SESSION['id']) || empty($_SESSION['is_admin'])) {
    header('Location: login.php');
    exit();
}

// Validate incoming id
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header('Location: admin.php');
    exit();
}
$item_id = (int)$_GET['id'];

$error = '';
$success = '';

// Handle POST (update)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = mysqli_real_escape_string($con, $_POST['name']);
    $price       = floatval($_POST['price']);
    $description = mysqli_real_escape_string($con, $_POST['description']);

    // Basic validation
    if ($name === '' || $price <= 0) {
        $error = 'Please enter a valid name and price.';
    } else {
        $updQ = "
            UPDATE items
            SET name        = '$name',
                price       = $price,
                description = '$description'
            WHERE id = $item_id
        ";
        if (mysqli_query($con, $updQ)) {
            // Redirect back to admin dashboard
            header('Location: admin.php');
            exit();
        } else {
            $error = 'Database error: ' . mysqli_error($con);
        }
    }
}

// On GET (or upon validation error) fetch current data
$selQ = "
    SELECT name, price, description
    FROM items
    WHERE id = $item_id
    LIMIT 1
";
$res = mysqli_query($con, $selQ);
if (!$res || mysqli_num_rows($res) !== 1) {
    die('Artwork not found.');
}
$art = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Artwork — The Indian Art Gallery</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css"           rel="stylesheet">
</head>
<body>
    <?php require_once __DIR__ . '/header.php'; ?>

    <div class="container" style="padding-top:80px;">
        <h2>Edit Artwork #<?php echo $item_id; ?></h2>

        <?php if ($error): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="name">Name</label>
                <input
                  type="text"
                  id="name"
                  name="name"
                  class="form-control"
                  value="<?php echo htmlspecialchars($art['name']); ?>"
                  required>
            </div>
            <div class="form-group">
                <label for="price">Price (USD)</label>
                <input
                  type="number"
                  step="0.01"
                  id="price"
                  name="price"
                  class="form-control"
                  value="<?php echo htmlspecialchars($art['price']); ?>"
                  required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea
                  id="description"
                  name="description"
                  class="form-control"
                  rows="4"><?php
                    echo htmlspecialchars($art['description']);
                ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="admin.php" class="btn btn-default">Cancel</a>
        </form>
    </div>

    <script src="bootstrap/js/jquery-3.2.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
