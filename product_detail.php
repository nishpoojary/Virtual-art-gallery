<?php
require_once'./connection.php';
session_start();

// Redirect if no ID given
if (!isset($_GET['id'])) {
    header('Location: products.php');
    exit();
}
$id = (int)$_GET['id'];

// Like / Unlike functionality
if (isset($_GET['like'], $_SESSION['id'])) {
    $uid = (int)$_SESSION['id'];
    
    // Verify user exists
    $user_check = $con->prepare("SELECT id FROM users WHERE id = ?");
    $user_check->bind_param("i", $uid);
    $user_check->execute();
    if ($user_check->get_result()->num_rows === 0) {
        $_SESSION['error'] = "User account not found";
        header("Location: product_detail.php?id=$id");
        exit();
    }
    $user_check->close();

    // Toggle like status
    $check = $con->prepare("SELECT id FROM likes WHERE item_id = ? AND user_id = ?");
    $check->bind_param("ii", $id, $uid);
    $check->execute();
    
    if ($check->get_result()->num_rows === 0) {
        $insert = $con->prepare("INSERT INTO likes (item_id, user_id) VALUES (?, ?)");
        $insert->bind_param("ii", $id, $uid);
        $insert->execute();
        $insert->close();
    } else {
        $delete = $con->prepare("DELETE FROM likes WHERE item_id = ? AND user_id = ?");
        $delete->bind_param("ii", $id, $uid);
        $delete->execute();
        $delete->close();
    }
    $check->close();
    
    header("Location: product_detail.php?id=$id#comments");
    exit();
}

// Handle comment submission
if (isset($_POST['comment'], $_SESSION['id'])) {
    $text = trim($_POST['comment_text'] ?? '');
    if ($text !== '') {
        $uid = (int)$_SESSION['id'];
        $stmt = $con->prepare("INSERT INTO comments (item_id, user_id, comment, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iis", $id, $uid, $text);
        $stmt->execute();
        $stmt->close();
        header("Location: product_detail.php?id=$id#comments");
        exit();
    }
}

// Fetch product details
$stmt = $con->prepare("SELECT * FROM items WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    echo "<p class='container pt-5'>Item not found.</p>";
    exit();
}
$item = $res->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/lifestyleStore.png" />
    <title>Product Details — The Indian Art Gallery</title>
    <!-- Bootstrap 3 CSS and JS (matching products.php) -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/jquery-3.2.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- Custom CSS (matching products.php) -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            padding-top: 80px; /* For fixed header, matching products.php */
        }
        .product-container {
            background: white;
            border-radius: 4px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-top: 30px;
        }
        .product-image-container {
            padding: 20px;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 400px;
        }
        .product-image {
            max-width: 100%;
            max-height: 400px;
            object-fit: contain;
            border-radius: 4px;
        }
        .product-info {
            padding: 20px;
        }
        .product-title {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
        }
        .product-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #6c63ff;
            margin-bottom: 20px;
        }
        .btn-like {
            min-width: 100px;
        }
        .action-buttons .btn {
            margin-right: 10px;
            margin-bottom: 10px;
        }
        .comments-section {
            margin-top: 40px;
            background: white;
            padding: 20px;
            border-radius: 4px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        babe2
        .comment-form textarea {
            min-height: 80px;
            margin-bottom: 10px;
        }
        .comment {
            padding: 10px;
            margin-bottom: 10px;
            background: #f8f9fa;
            border-radius: 4px;
            border-left: 3px solid #6c63ff;
        }
        .comment-author {
            font-weight: bold;
            color: #6c63ff;
        }
        .comment-date {
            font-size: 0.8rem;
            color: #666;
        }
        .no-image-placeholder {
            width: 100%;
            height: 400px;
なんだ2
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e9ecef;
            color: #6c757d;
            border-radius: 4px;
        }
        footer {
            background: #333;
            color: white;
            padding: 20px 0;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <?php require 'header.php'; ?>

    <div class="container" style="padding-top: 80px;">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        
        <div class="product-container">
            <div class="row">
                <div class="col-md-6">
                    <div class="product-image-container">
                        <?php
                        $img = !empty($item['image'])
                            ? "/art_main/DBMS-Mini-Project-master/src/upload/" . htmlspecialchars($item['image'])
                            : null;
                        
                        if ($img && file_exists($_SERVER['DOCUMENT_ROOT'] . $img)): ?>
                            <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="product-image">
                        <?php else: ?>
                            <div class="no-image-placeholder">
                                <div class="text-center">
                                    <i class="fas fa-image fa-4x mb-3"></i>
                                    <p>No image available</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="product-info">
                        <h1 class="product-title"><?php echo htmlspecialchars($item['name']); ?></h1>
                        <div class="product-price">₹<?php echo number_format($item['price'], 2); ?></div>
                        
                        <?php if (!empty($item[''])): ?>
                            <div class="product-description mb-4">
                                <h5>Description</h5>
                                <p><?php echo nl2br(htmlspecialchars($item['description'])); ?></p>
                            </div>
                        <?php endif; ?>
                        
                        <div class="action-buttons mb-4">
                            <?php
                            // Like count
                            $stmt = $con->prepare("SELECT COUNT(*) as cnt FROM likes WHERE item_id = ?");
                            $stmt->bind_param("i", $id);
                            $stmt->execute();
                            $likeCnt = $stmt->get_result()->fetch_assoc()['cnt'];
                            $stmt->close();
                            
                            // Check if user liked
                            $userLiked = false;
                            if (isset($_SESSION['id'])) {
                                $stmt = $con->prepare("SELECT id FROM likes WHERE item_id = ? AND user_id = ?");
                                $stmt->bind_param("ii", $id, $_SESSION['id']);
                                $stmt->execute();
                                $userLiked = $stmt->get_result()->num_rows > 0;
                                $stmt->close();
                            }
                            ?>
                            
                            <a href="product_detail.php?id=<?php echo $id; ?>&like=<?php echo $id; ?>" 
                               class="btn btn-<?php echo $userLiked ? 'danger' : 'primary'; ?> btn-like">
                                <i class="fas fa-heart me-2"></i>
                                <?php echo $userLiked ? 'Unlike' : 'Like'; ?>
                                <span class="badge bg-light text-dark ms-2"><?php echo $likeCnt; ?></span>
                            </a>
                            
                            <form method="POST" action="cart_add.php" class="d-inline">
                                <input type="hidden" name="item_id" value="<?php echo $id; ?>">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-shopping-cart me-2"></i>Add to Wishlist
                                </button>
                            </form>
                        </div>
                        
                        <div class="product-meta">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-palette me-2 text-muted"></i>
                                <span>Category: <?php echo htmlspecialchars($item['category'] ?? 'N/A'); ?></span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-ruler-combined me-2 text-muted"></i>
                                <span>Dimensions: <?php echo htmlspecialchars($item['dimensions'] ?? 'N/A'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="comments-section" id="comments">
            <h4 class="mb-4"><i class="fas fa-comments me-2"></i>Comments</h4>
            
            <?php if (isset($_SESSION['id'])): ?>
                <form method="POST" action="product_detail.php?id=<?php echo $id; ?>#comments" class="comment-form mb-5">
                    <div class="form-group">
                        <textarea name="comment_text" id="commentText" class="form-control" placeholder="Add a comment" required></textarea>
                    </div>
                    <button type="submit" name="comment" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i>Post Comment
                    </button>
                </form>
            <?php else: ?>
                <div class="alert alert-info">
                    <a href="login.php" class="alert-link">Sign in</a> to leave a comment.
                </div>
            <?php endif; ?>

            <div class="comments-list">
                <?php
                $stmt = $con->prepare("
                    SELECT c.comment, u.email, c.created_at
                    FROM comments c
                    JOIN users u ON c.user_id=u.id
                    WHERE c.item_id=?
                    ORDER BY c.created_at DESC
                ");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $cmts = $stmt->get_result();
                
                if ($cmts->num_rows === 0): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-comment-slash fa-2x text-muted mb-3"></i>
                        <p class="text-muted">No comments yet. Be the first to share your thoughts!</p>
                    </div>
                <?php else:
                    while ($c = $cmts->fetch_assoc()): ?>
                        <div class="comment">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="comment-author"><?php echo htmlspecialchars($c['email']); ?></span>
                                <span class="comment-date"><?php echo date('M j, Y \a\t g:i a', strtotime($c['created_at'])); ?></span>
                            </div>
                            <p><?php echo htmlspecialchars($c['comment']); ?></p>
                        </div>
                    <?php endwhile;
                endif;
                $stmt->close();
                ?>
            </div>
        </div>
    </div>
<br>
<br>
<br>
<br>
<br>
<br>
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>The Indian Art Gallery</h5>
                    <p>Celebrating the rich heritage and contemporary expressions of Indian art.</p>
                </div>
                <div class="col-md-6 text-md-right">
                    <p>Contact us: <a href="mailto:art@artgallery.com" class="text-white">art@artgallery.com</a></p>
                    <p>© <?php echo date('Y'); ?> All Rights Reserved</p>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>