<?php
// signup.php

require_once __DIR__ . '/connection.php';
session_start();

$errors = [];
$email = '';
$name = '';
$contact = '';
$city = '';
$address = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name             = trim($_POST['name'] ?? '');
    $email            = trim($_POST['email'] ?? '');
    $contact          = trim($_POST['contact'] ?? '');
    $city             = trim($_POST['city'] ?? '');
    $address          = trim($_POST['address'] ?? '');
    $password         = $_POST['password']         ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (!$name) {
        $errors[] = 'Name is required.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email.';
    }
    if (!$contact || !preg_match('/^\d{10}$/', $contact)) {
        $errors[] = 'Please enter a valid 10-digit contact number.';
    }
    if (!$city) {
        $errors[] = 'City is required.';
    }
    if (!$address) {
        $errors[] = 'Address is required.';
    }
    if (strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters.';
    }
    if ($password !== $confirm_password) {
        $errors[] = 'Passwords do not match.';
    }

    if (empty($errors)) {
        $esc_name    = mysqli_real_escape_string($con, $name);
        $esc_email   = mysqli_real_escape_string($con, $email);
        $esc_contact = mysqli_real_escape_string($con, $contact);
        $esc_city    = mysqli_real_escape_string($con, $city);
        $esc_address = mysqli_real_escape_string($con, $address);

        $check = mysqli_query($con, "SELECT id FROM users WHERE email='$esc_email'");
        if ($check && mysqli_num_rows($check) > 0) {
            $errors[] = 'That email is already registered.';
        } else {
            $hash = md5($password);
            mysqli_query($con, "INSERT INTO users (name, email, password, contact, city, address) VALUES ('$esc_name', '$esc_email', '$hash', '$esc_contact', '$esc_city', '$esc_address')")
              or die(mysqli_error($con));
            $_SESSION['id']       = mysqli_insert_id($con);
            $_SESSION['email']    = $email;
            $_SESSION['is_admin'] = 0;
            header('Location: products.php');
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Sign Up • The Indian Art Gallery</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f7f9fc; font-family: Arial, sans-serif; }
    .auth-container { max-width: 400px; margin: 80px auto; }
    .auth-card { background: #fff; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); padding: 30px; }
    .auth-card h2 { margin-bottom: 24px; font-weight: 600; text-align: center; color: #333; }
    .form-control { border-radius: 4px; height: 44px; }
    .btn-primary { border-radius: 4px; height: 44px; font-size: 16px; font-weight: 500; }
    .text-link { color: #007bff; text-decoration: none; }
    .text-link:hover { text-decoration: underline; }
    footer.footer { margin-top: 40px; padding: 20px 0; text-align: center; color: #777; font-size: 14px; }
  </style>
</head>
<body>
  <div class="auth-container">
    <div class="auth-card">
      <h2>Create Account</h2>

      <?php if ($errors): ?>
        <div class="alert alert-danger">
          <?php foreach ($errors as $e): ?>
            <div><?php echo htmlspecialchars($e); ?></div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <form method="POST" novalidate>
        <div class="form-group mb-3">
          <input type="text" name="name" class="form-control" placeholder="Full name" required value="<?php echo htmlspecialchars($name); ?>">
        </div>
        <div class="form-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email address" required value="<?php echo htmlspecialchars($email); ?>">
        </div>
        <div class="form-group mb-3">
          <input type="text" name="contact" class="form-control" placeholder="Contact number" required value="<?php echo htmlspecialchars($contact); ?>">
        </div>
        <div class="form-group mb-3">
          <input type="text" name="city" class="form-control" placeholder="City" required value="<?php echo htmlspecialchars($city); ?>">
        </div>
        <div class="form-group mb-3">
          <input type="text" name="address" class="form-control" placeholder="Address" required value="<?php echo htmlspecialchars($address); ?>">
        </div>
        <div class="form-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="form-group mb-3">
          <input type="password" name="confirm_password" class="form-control" placeholder="Confirm password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block w-100">Sign Up</button>
      </form>

      <p class="text-center mt-3">
        Already have an account?
        <a href="login.php" class="text-link">Log in</a>
      </p>
    </div>
  </div>

  <footer class="footer">
    Showcase your creative talent at The Indian Art Gallery. Contact at
    <a href="mailto:art@artgallery.com" class="text-link">art@artgallery.com</a>
  </footer>
</body>
</html>
