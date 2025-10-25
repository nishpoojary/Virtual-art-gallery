<?php 
require_once __DIR__ . '/connection.php'; 
session_start(); 

// Like / Unlike toggle
if (isset($_GET['like'], $_SESSION['id'])) { 
    $item_id = mysqli_real_escape_string($con, $_GET['like']); 
    $user_id = $_SESSION['id']; 

    $check = mysqli_query(
        $con,
        "SELECT 1 
           FROM likes 
          WHERE item_id='$item_id' 
            AND user_id='$user_id'"
    );
    if (mysqli_num_rows($check) === 0) { 
        mysqli_query(
            $con,
            "INSERT INTO likes (item_id, user_id) 
                    VALUES ('$item_id', '$user_id')"
        ); 
    } else { 
        mysqli_query(
            $con,
            "DELETE 
               FROM likes 
              WHERE item_id='$item_id' 
                AND user_id='$user_id'"
        ); 
    } 
    header("Location: products.php#item$item_id"); 
    exit(); 
} 

// Fetch all items
$result = mysqli_query($con, "SELECT * FROM items"); 
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="img/lifestyleStore.png" />
    <title>Products — The Indian Art Gallery</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/jquery-3.2.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .test1 { background: url(img/about.jpg) center/cover no-repeat; min-height:100vh; }
        .thumbnail { margin-bottom:20px; border-radius:4px; overflow:hidden; box-shadow:0 2px 6px rgba(0,0,0,0.1); }
        .thumbnail img { width:100%; height:200px; object-fit:cover; }
        .caption h3 a { color:#333; text-decoration:none; }
        .caption h3 a:hover { text-decoration:underline; }
        .btn-sm { padding:5px 10px; font-size:13px; }
    </style>
</head>
<body>
    <?php require 'header.php'; ?>

    <div class="test1">
      <div class="container" style="padding-top:80px;">
        <h2>Artworks</h2>
        <div class="row">
        <?php while ($row = mysqli_fetch_assoc($result)): 
            $id = (int)$row['id'];
            $img = !empty($row['image'])
  ? "/art_main/DBMS-Mini-Project-master/src/upload/" . htmlspecialchars($row['image'])
  : null;


            // like count
            $lc = mysqli_fetch_assoc(
                mysqli_query($con, "SELECT COUNT(*) AS cnt FROM likes WHERE item_id='$id'")
            )['cnt'];

            // user liked?
            $liked = false;
            if (isset($_SESSION['id'])) {
                $liked = mysqli_num_rows(
                    mysqli_query(
                        $con,
                        "SELECT 1 FROM likes WHERE item_id='$id' AND user_id='{$_SESSION['id']}'"
                    )
                ) > 0;
            }
        ?>
          <div class="col-md-4" id="item<?php echo $id; ?>">
            <div class="thumbnail">
             <?php if ($img): ?>
  <a href="product_detail.php?id=<?php echo $id; ?>">
    <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" style="width:100%; height:200px; object-fit:cover; border-radius:6px;">
  </a>
<?php else: ?>
  <div style="height:200px;background:#f0f0f0;display:flex;
              align-items:center;justify-content:center;color:#888; border-radius:6px;">
    No image available
  </div>
<?php endif; ?>


              <div class="caption" style="padding:15px;">
                <h3 style="margin-top:0;">
                  <a href="product_detail.php?id=<?php echo $id; ?>">
                    <?php echo htmlspecialchars($row['name']); ?>
                  </a>
                </h3>
                <p>Price: ₹<?php echo number_format($row['price'],2); ?></p>
                <p>
                  <a 
                    href="?like=<?php echo $id; ?>" 
                    class="btn btn-<?php echo $liked?'danger':'primary'; ?> btn-sm"
                  >
                    <?php echo $liked?'Unlike':'Like'; ?> (<?php echo $lc; ?>)
                  </a>
                  <!-- POST form for Add to Cart -->
                  <form 
                    method="POST" 
                    action="cart_add.php" 
                    style="display:inline;"
                  >
                    <input type="hidden" name="item_id" value="<?php echo $id; ?>">
                    <button type="submit" class="btn btn-success btn-sm">
                      Add to Wishlist
                    </button>
                  </form>
                </p>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
        </div>
      </div>
    </div>
</body>
</html>
