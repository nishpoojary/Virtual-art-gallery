<?php
    require 'connection.php';
    session_start();
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['password']; // Don't hash the input password, password_verify will do that
    $regex_email="/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[_a-z0-9-]+)*(\.[a-z]{2,3})$/";
    if(!preg_match($regex_email,$email)){
        echo "Incorrect email. Redirecting you back to login page...";
        ?>
        <meta http-equiv="refresh" content="2;url=login.php" />
        <?php
        exit();
    }
    if(strlen($password) < 6){
        echo "Password should have at least 6 characters. Redirecting you back to login page...";
        ?>
        <meta http-equiv="refresh" content="2;url=login.php" />
        <?php
        exit();
    }
    $stmt = $con->prepare("SELECT id, password, is_admin FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['is_admin'] = $row['is_admin'];
            if ($row['is_admin'] == 1) {
                header("Location: admin.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            echo "Incorrect password. Redirecting you back to login page...";
            ?>
            <meta http-equiv="refresh" content="2;url=login.php" />
            <?php
            exit();
        }
    } else {
        echo "No user found with this email. Redirecting you back to login page...";
        ?>
        <meta http-equiv="refresh" content="2;url=login.php" />
        <?php
        exit();
    }
    
 ?>