<?php
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/connection.php';
// DO NOT use session_start(); it's in header.php

$errors = [];
$success = '';
$imageFileName = '';
$name = $price = $description = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = trim($_POST['name'] ?? '');
    $price       = trim($_POST['price'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if (!$name)        $errors[] = 'Artwork name is required.';
    if (!$price)       $errors[] = 'Price is required.';
    if (!$description) $errors[] = 'Description is required.';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName    = basename($_FILES['image']['name']);
        $uploadDir   = __DIR__ . '/upload/';
        $targetPath  = $uploadDir . $fileName;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if (move_uploaded_file($fileTmpPath, $targetPath)) {
            $imageFileName = $fileName;
        } else {
            $errors[] = 'Image upload failed.';
        }
    } else {
        $errors[] = 'Please upload an image.';
    }

    if (empty($errors)) {
        $esc_name = mysqli_real_escape_string($con, $name);
        $esc_price = mysqli_real_escape_string($con, $price);
        $esc_desc = mysqli_real_escape_string($con, $description);
        $esc_image = mysqli_real_escape_string($con, $imageFileName);

        $query = "INSERT INTO items (name, price, description, image) 
                  VALUES ('$esc_name', '$esc_price', '$esc_desc', '$esc_image')";
        mysqli_query($con, $query) or die(mysqli_error($con));
        $success = "Artwork added successfully!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Add Artwork • The Indian Art Gallery</title>
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f7f9fc; font-family: Arial, sans-serif; }
    .auth-container { max-width: 500px; margin: 80px auto; }
    .auth-card {
      background: #fff; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); padding: 30px;
    }
    .auth-card h2 { margin-bottom: 24px; font-weight: 600; text-align: center; color: #333; }
    .form-control { border-radius: 4px; height: 44px; }
    .btn-primary { border-radius: 4px; height: 44px; font-size: 16px; font-weight: 500; }
    .text-link { color: #007bff; text-decoration: none; }
    .text-link:hover { text-decoration: underline; }
    .img-preview { max-width: 100%; margin-top: 20px; border: 1px solid #ccc; padding: 4px; border-radius: 6px; }
    footer.footer {
      margin-top: 40px; padding: 20px 0; text-align: center; color: #777; font-size: 14px;
    }
  </style>
</head>
<body>
  <div class="auth-container">
    <div class="auth-card">
      <h2>Add New Artwork</h2>

      <?php if ($success): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
      <?php endif; ?>

      <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
          <?php foreach ($errors as $e): ?>
            <div><?php echo htmlspecialchars($e); ?></div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <form method="POST" enctype="multipart/form-data" novalidate>
        <div class="form-group mb-3">
          <input type="text" name="name" class="form-control" placeholder="Artwork name" required value="<?php echo htmlspecialchars($name); ?>">
        </div>
        <div class="form-group mb-3">
          <input type="number" name="price" class="form-control" placeholder="Price in ₹" required value="<?php echo htmlspecialchars($price); ?>">
        </div>
        <div class="form-group mb-3">
          <textarea name="description" class="form-control" placeholder="Description" rows="4" required><?php echo htmlspecialchars($description); ?></textarea>
        </div>
        <div class="form-group mb-3">
          <input type="file" name="image" class="form-control" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block w-100">Add Artwork</button>
      </form>

      <?php if ($imageFileName): ?>
        <div class="mt-4">
          <h5 class="text-center">Preview</h5>
        <img src="/art_main/DBMS-Mini-Project-master/src/upload/<?php echo htmlspecialchars($imageFileName); ?>" class="img-preview" alt="Artwork image">


        </div>
      <?php endif; ?>
    </div>
  </div>

  <footer class="footer">
    Showcase your creative talent at The Indian Art Gallery. Contact at
    <a href="mailto:art@artgallery.com" class="text-link">art@artgallery.com</a>
  </footer>
</body>
</html>
