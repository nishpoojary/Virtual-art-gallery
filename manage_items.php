<?php
require 'connection.php';
session_start();

// Check if admin is logged in
if (!isset($_SESSION['email']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: admin.php');
    exit();
}

// Handle add artwork
if (isset($_POST['add'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $price = mysqli_real_escape_string($con, $_POST['price']);
    $image_path = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "Uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $image_path = $target_dir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
    }
    $query = "INSERT INTO items (name, price) VALUES ('$name', '$price')";
    mysqli_query($con, $query) or die(mysqli_error($con));
    echo "<div class='alert alert-success'>Artwork added!</div>";
}

// Handle edit artwork
if (isset($_POST['edit'])) {
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $price = mysqli_real_escape_string($con, $_POST['price']);
    $image_path = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "Uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $image_path = $target_dir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
    }
    $query = "UPDATE items SET name='$name', price='$price'" . ($image_path ? ", image='$image_path'" : "") . " WHERE id='$id'";
    mysqli_query($con, $query) or die(mysqli_error($con));
    echo "<div class='alert alert-success'>Artwork updated!</div>";
}

// Handle delete artwork
if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($con, $_GET['delete']);
    $query = "DELETE FROM items WHERE id='$id'";
    mysqli_query($con, $query) or die(mysqli_error($con));
    echo "<div class='alert alert-success'>Artwork deleted!</div>";
}

// Fetch items for editing
$edit_item = null;
if (isset($_GET['edit'])) {
    $id = mysqli_real_escape_string($con, $_GET['edit']);
    $result = mysqli_query($con, "SELECT * FROM items WHERE id='$id'");
    $edit_item = mysqli_fetch_assoc($result);
}

$result = mysqli_query($con, "SELECT * FROM items");
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="img/lifestyleStore.png" />
    <title>Manage Artworks</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css">
    <script src="bootstrap/js/jquery-3.2.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <style>
        .test1 { background-image: url(img/about.jpg); background-size: cover; background-position: center; min-height: 100vh; }
        .panel { background-color: rgba(255, 255, 255, 0.9); }
        .footer { background-color: #333; color: white; padding: 20px; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div>
        <?php require 'header.php'; ?>
        <div class="test1">
            <div class="container">
                <div class="row">
                    <div class="col-xs-6 col-xs-offset-3">
                        <br><br>
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3><?php echo $edit_item ? 'EDIT ARTWORK' : 'ADD NEW ARTWORK'; ?></h3>
                            </div>
                            <div class="panel-body">
                                <form method="POST" enctype="multipart/form-data">
                                    <?php if ($edit_item) { ?>
                                        <input type="hidden" name="id" value="<?php echo $edit_item['id']; ?>">
                                    <?php } ?>
                                    <div class="form-group">
                                        <input type="text" class="form-control name" placeholder="Name" name="name" required value="<?php echo $edit_item ? htmlspecialchars($edit_item['name']) : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="form-control" name="price" placeholder="Price" type="number" required value="<?php echo $edit_item ? htmlspecialchars($edit_item['price']) : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Upload Image (optional):</label>
                                        <input type="file" name="image" id="image" accept="image/*">
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" name="<?php echo $edit_item ? 'edit' : 'add'; ?>" value="<?php echo $edit_item ? 'Update Artwork' : 'Add Artwork'; ?>" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <h3>Existing Artworks</h3>
                        <table>
                            <tr><th>ID</th><th>Name</th><th>Price</th><th>Actions</th></tr>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['price']; ?></td>
                                    <td>
                                        <a href="?edit=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container">
                <center>
                    <p>Opportunity to showcase your creative talent at The Indian Art Gallery. Contact us at art@artgallery.com</p>
                </center>
            </div>
        </footer>
    </div>
</body>
</html>