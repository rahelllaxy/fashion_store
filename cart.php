<?php
require_once "components/navbar.php";
$productName = isset($_POST['product_name']) ? $_POST['product_name'] : null;
$productPrice = isset($_POST['product_price']) ? $_POST['product_price'] : 0;
$productSize = isset($_POST['size']) ? $_POST['size'] : '-';
$formattedPrice = "Rp " . number_format($productPrice, 0, ',', '.');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - AETHER STYLE</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-white">

<section class="cart-page">
    <div class="cart-container">
        <h2>Keranjang Belanja</h2>

        <?php if ($productName): ?>
            <div class="cart-item">
                <div class="cart-item-info">
                    <h3><?= htmlspecialchars($productName) ?></h3>
                    <p>Size: <?= htmlspecialchars($productSize) ?></p>
                </div>
                <div class="cart-item-price">
                    <h3><?= $formattedPrice ?></h3>
                </div>
            </div>
            
            <a href="#" class="checkout-btn">Lanjut Pembayaran (Checkout)</a>
        <?php else: ?>
            <div style="margin-top: 30px; padding: 20px; background: #f5f5f5; border-radius: 8px;">
                <p>Belum ada produk yang ditambahkan ke keranjang.</p>
                <a href="index.php" style="display:inline-block; margin-top:15px; color:black; font-weight:bold; text-decoration:none;">&larr; Kembali Belanja</a>
            </div>
        <?php endif; ?>

    </div>
</section>

<?php
require_once "components/footer.php";
?>
</body>
</html>