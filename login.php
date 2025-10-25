<?php
// login.php

require_once __DIR__ . '/connection.php';
session_start();

// Redirect if already logged in
if (isset($_SESSION['id'])) {
    header($_SESSION['is_admin']
        ? 'Location: admin.php'
        : 'Location: products.php'
    );
    exit();
}

$error = '';
$email = '';
$role  = 'user';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role     = $_POST['role']     ?? 'user';
    $email    = trim($_POST['email']    ?? '');
    $password =          $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = 'Please fill out both email and password.';
    } else {
        $esc = mysqli_real_escape_string($con, $email);

        if ($role === 'admin') {
            $res = mysqli_query($con,
              "SELECT aid AS id, password
               FROM admin
               WHERE email='$esc'
               LIMIT 1"
            );
            if ($res && mysqli_num_rows($res) === 1) {
                $row    = mysqli_fetch_assoc($res);
                $stored = $row['password'];
                $input  = md5($password);
                if (substr($input,0,strlen($stored)) === $stored) {
                    $_SESSION['id']       = $row['id'];
                    $_SESSION['is_admin'] = 1;
                    header('Location: admin.php');
                    exit();
                } else {
                    $error = 'Incorrect password.';
                }
            } else {
                $error = 'Admin email not found.';
            }
        } else {
            $res = mysqli_query($con,
              "SELECT id,password,is_admin
               FROM users
               WHERE email='$esc'
               LIMIT 1"
            );
            if ($res && mysqli_num_rows($res) === 1) {
                $u = mysqli_fetch_assoc($res);
                if (md5($password) === $u['password']) {
                    $_SESSION['id']       = $u['id'];
                    $_SESSION['is_admin'] = (int)$u['is_admin'];
                    header('Location: products.php');
                    exit();
                } else {
                    $error = 'Incorrect password.';
                }
            } else {
                $error = 'User email not found.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Login • The Indian Art Gallery</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f7f9fc;
      font-family: Arial, sans-serif;
    }
    .auth-container {
      max-width: 400px;
      margin: 80px auto;
    }
    .auth-card {
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      padding: 30px;
    }
    .auth-card h2 {
      margin-bottom: 24px;
      font-weight: 600;
      text-align: center;
      color: #333;
    }
    .form-control {
      border-radius: 4px;
      height: 44px;
    }
    .btn-primary {
      border-radius: 4px;
      height: 44px;
      font-size: 16px;
      font-weight: 500;
    }
    .radio-inline {
      margin-right: 16px;
      font-size: 14px;
      color: #555;
    }
    .text-link {
      color: #007bff;
      text-decoration: none;
    }
    .text-link:hover {
      text-decoration: underline;
    }
    footer.footer {
      margin-top: 40px;
      padding: 20px 0;
      text-align: center;
      color: #777;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <div class="auth-container">
    <div class="auth-card">
      <h2>Log In</h2>
      <?php if ($error): ?>
        <div class="alert alert-danger">
          <?php echo htmlspecialchars($error); ?>
        </div>
      <?php endif; ?>

      <form method="POST" novalidate>
        <div class="form-group">
          <label class="radio-inline">
            <input type="radio" name="role" value="user"
                   <?php if ($role==='user') echo 'checked'; ?>>
            User
          </label>
          <label class="radio-inline">
            <input type="radio" name="role" value="admin"
                   <?php if ($role==='admin') echo 'checked'; ?>>
            Admin
          </label>
        </div>
        <div class="form-group">
          <input type="email"
                 name="email"
                 class="form-control"
                 placeholder="Email address"
                 required
                 autofocus
                 value="<?php echo htmlspecialchars($email); ?>">
        </div>
        <div class="form-group">
          <input type="password"
                 name="password"
                 class="form-control"
                 placeholder="Password"
                 required>
        </div>
        <button type="submit"
                class="btn btn-primary btn-block">
          Log In
        </button>
      </form>

      <p class="text-center mt-3">
        Don't have an account?
        <a href="signup.php" class="text-link">Sign up</a>
      </p>
    </div>
  </div>

  <footer class="footer">
    Showcase your creative talent at The Indian Art Gallery. Contact at
    <a href="mailto:art@artgallery.com" class="text-link">art@artgallery.com</a>
  </footer>
</body>
</html>
