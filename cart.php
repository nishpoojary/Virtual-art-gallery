<?php
// cart.php

require_once __DIR__ . '/connection.php';
session_start();

// Must be logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

$user_id = (int)$_SESSION['id'];

// Fetch cart items
$sql = "
    SELECT i.id, i.name, i.price
      FROM items AS i
      JOIN users_items AS ui
        ON i.id = ui.item_id
     WHERE ui.user_id = ?
       AND ui.status  = 'Added to cart'
";
$stmt = $con->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$res = $stmt->get_result();

$items = [];
$total = 0.0;
while ($row = $res->fetch_assoc()) {
    $items[] = $row;
    $total  += (float)$row['price'];
}
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your Wishlist — The Indian Art Gallery</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/jquery-3.2.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link href="css/style.css" rel="stylesheet">
    <style>
      .container { padding-top:80px; }
      .table th, .table td { vertical-align: middle; }
      .btn-sm { padding:5px 10px; font-size:13px; }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/header.php'; ?>

    <div class="container">
      <h2>Your wishlist</h2>

      <?php if (empty($items)): ?>
        <p>Your cart is empty. <a href="products.php">Browse artworks</a>.</p>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Artwork</th>
                <th>Price</th>
                <th>Remove</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($items as $it): ?>
                <tr>
                  <td><?php echo htmlspecialchars($it['name']); ?></td>
                  <td>₹<?php echo number_format($it['price'], 2); ?></td>
                  <td>
                    <!-- POST form to remove -->
                    <form method="POST" action="cart_remove.php" style="display:inline;">
                      <input type="hidden" name="item_id" value="<?php echo $it['id']; ?>">
                      <button type="submit" class="btn btn-danger btn-sm">
                        Remove
                      </button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>

              <tr>
                <td><strong>Total</strong></td>
                <td><strong>₹<?php echo number_format($total, 2); ?></strong></td>
                <td>
                  <a href="success.php" class="btn btn-primary">
                    Confirm Order
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
</body>
</html>
