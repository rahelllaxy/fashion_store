<?php
// 1. PANGGIL KONEKSI DATABASE DAN MODEL
require_once 'config/Database.php';
require_once 'models/ProductModel.php';

$db = (new Database())->getConnection();
$model = new ProductModel($db);

$id = $_GET['id'] ?? '';
$product = $model->readOne($id);

if (!$product) {
    echo "<script>alert('Produk tidak ditemukan!'); window.location.href='index.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']) ?> - AETHER COLLECTIVE</title>
    
    <style>
    
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #fcfcfc; }
        .navbar { background-color: #000; color: #fff; padding: 20px 50px; display: flex; justify-content: space-between; align-items: center; }
        .navbar a { color: #fff; text-decoration: none; margin: 0 15px; font-weight: bold; font-size: 14px; }
        .navbar .brand { font-size: 24px; font-weight: 900; letter-spacing: 1px; }
        .navbar .btn-admin { border: 1px solid #fff; padding: 5px 15px; border-radius: 20px; }
        
        .container { display: flex; max-width: 1100px; margin: 50px auto; gap: 50px; padding: 20px; background: #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .product-image { flex: 1; text-align: center; padding: 20px; border: 1px solid #eee; }
        .product-image img { max-width: 100%; max-height: 500px; object-fit: cover; }
        
        .product-details { flex: 1; padding: 20px 0; }
        .product-details h1 { font-size: 32px; text-transform: uppercase; margin-bottom: 15px; color: #111; }
        .product-details .price { font-size: 26px; font-weight: bold; margin-bottom: 30px; color: #222; }
        
        .sizes-title { font-weight: bold; margin-bottom: 10px; color: #003366; }
        .sizes { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 40px; }
        .size-box { border: 1px solid #ddd; padding: 10px 15px; cursor: pointer; text-align: center; min-width: 40px; border-radius: 4px; transition: 0.3s; }
        .size-box:hover { border-color: #111; }
        .size-box.active { border-color: #003366; font-weight: bold; color: #003366; background: #f0f4f8; }
        
        .desc-text { color: #555; line-height: 1.6; margin-bottom: 40px; font-size: 15px; }

        .btn-action { 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            gap: 10px; 
            width: 100%; 
            padding: 15px; 
            text-decoration: none; 
            font-weight: bold; 
            color: #fff; 
            margin-bottom: 15px; 
            border-radius: 5px; 
            font-size: 16px; 
            transition: 0.3s; 
            box-sizing: border-box; 
        }
        .btn-shopee { background-color: #ee4d2d; }
        .btn-shopee:hover { background-color: #d73a1e; }
        .btn-maps { background-color: #28a745; }
        .btn-maps:hover { background-color: #218838; }
        .btn-logo { width: 24px; height: 24px; object-fit: cover; border-radius: 4px; }
        .btn-maps .btn-logo { border-radius: 50%; } 
    </style>
</head>
<body>

    <div class="navbar">
        <div class="brand">AETHER COLLECTIVE</div>
        <div class="nav-links">
            <a href="index.php">Semua Produk</a>
            <a href="index.php?filter=kemeja-pria">Kemeja Pria</a>
            <a href="index.php?filter=kemeja-wanita">Kemeja Wanita</a>
            <a href="index.php?filter=parfum">Parfum</a>
            <a href="index.php">Home</a>
            <a href="index.php">About</a>
            <a href="admin.php?action=dashboard" class="btn-admin">Admin</a>
        </div>
    </div>

    <div class="container">
        
        <div class="product-image">
            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
        </div>

        <div class="product-details">
            <h1><?= htmlspecialchars($product['name']) ?></h1>
            
            <p class="price">Rp <?= number_format($product['price'], 0, ',', '.') ?></p>

            <?php 
            
            if (strpos(strtolower($product['category']), 'parfum') !== false): 
            ?>
                <div class="sizes-title">Deskripsi Produk</div>
                <div class="desc-text">
                    
                </div>

            <?php else: ?>
                <div class="sizes-title">Size</div>
                <div class="sizes">
                    <div class="size-box active">S</div>
                    <div class="size-box">M</div>
                    <div class="size-box">L</div>
                    <div class="size-box">XL</div>
                    <div class="size-box">XXL</div>
                    <div class="size-box">28</div>
                    <div class="size-box">30</div>
                    <div class="size-box">32</div>
                    <div class="size-box">34</div>
                    <div class="size-box">36</div>
                </div>
            <?php endif; ?>
            <a href="<?= htmlspecialchars($product['shopee']) ?>" target="_blank" class="btn-action btn-shopee">
                <img src="assets/img/shopee.jpg" alt="Shopee" class="btn-logo">
                Beli via Shopee
            </a>
            
            <a href="https://maps.google.com/" target="_blank" class="btn-action btn-maps">
                <img src="assets/img/Google_Maps_Logo.jpg" alt="Maps" class="btn-logo">
                Beli via Lokasi Maps
            </a>
        </div>
    </div>

</body>
</html>