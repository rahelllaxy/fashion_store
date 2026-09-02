<?php
require_once "components/navbar.php";
require_once "config/Database.php";
require_once "models/ProductModel.php";
require_once "classes/FashionProduct.php";

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

// 1. KONEKSI DATABASE
$db = (new Database())->getConnection();
$model = new ProductModel($db);

$stmt = $model->readAll();
$products = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $products[] = new FashionProduct(
        $row['id'], 
        $row['name'], 
        $row['price'], 
        $row['image'], 
        $row['category'], 
        $row['shopee']
    );
}

$testiStmt = $model->readTestimonials();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AETHER COLLECTIVE</title>
    <!-- Query string ?v=time() untuk mencegah cache CSS -->
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time(); ?>">
</head>
<body>

<section class="hero" id="home">
    <div class="hero-content">
        <h1>REDEFINE YOUR ESSENCE</h1>
        <p>Curated streetwear and signature fragrances for the modern lifestyle.</p>
        <a href="index.php?filter=all#product" class="hero-btn">Shop Now</a>
    </div>
</section>

<section class="about" id="about">
    <div class="about-image">
        <img src="assets/img/about.jpg" alt="About Aether Collective">
    </div>
    <div class="about-text">
        <h2>Tentang Kami</h2>
        <p>AETHER COLLECTIVE adalah destinasi utama untuk pakaian bergaya kasual dan koleksi parfum premium. Kami percaya bahwa gaya adalah tentang mengekspresikan jati diri Anda yang sebenarnya tanpa kompromi.</p>
        <a href="#product" class="about-btn">Lihat Koleksi Kami</a>
    </div>
</section>

<section class="product" id="product">
    <h2 class="product-title">Our Product</h2>
    <div class="product-container">
        <?php if(empty($products)): ?>
            <p style="color: white; text-align: center; width: 100%;">Belum ada produk. Silakan tambahkan melalui Dashboard Admin.</p>
        <?php else: ?>
            <?php foreach ($products as $prod): ?>
                <?php if ($filter == 'all' || $filter == $prod->getCategory()): ?>
                    <div class="product-card">
                        <img src="<?= htmlspecialchars($prod->getImage()) ?>" alt="<?= htmlspecialchars($prod->getName()) ?>">
                        <div class="product-info">
                            <h3><?= htmlspecialchars($prod->getName()) ?></h3>
                            <p><?= ucfirst(str_replace('-', ' ', htmlspecialchars($prod->getCategory()))) ?></p>
                            <div class="price">Rp <?= number_format($prod->getPrice(), 0, ',', '.') ?></div>
                            <a href="detail.php?id=<?= urlencode($prod->getId()) ?>" class="buy-btn">Buy Now</a>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div> 
</section>

<section class="testimonial" id="review">
    <h2 class="testimonial-title">Apa Kata Mereka?</h2>
    <div class="testimonial-container">
        <?php 
        if ($testiStmt->rowCount() > 0):
            while ($t = $testiStmt->fetch(PDO::FETCH_ASSOC)): 
                // Mengubah angka rating menjadi simbol bintang emas
                $rating = (int)$t['rating'];
                $stars = str_repeat("★", $rating) . str_repeat("☆", 5 - $rating);
        ?>
            <div class="testimonial-card">
                <h3><?= htmlspecialchars($t['customer_name']) ?></h3>
                <p>"<?= htmlspecialchars($t['review']) ?>"</p>
                <div class="rating" style="color: gold; margin-top: 10px; font-size: 1.2rem;">
                    <?= $stars ?>
                </div>
            </div>
        <?php 
            endwhile; 
        else: 
        ?>
            <p style="color: white; text-align: center; width: 100%;">Belum ada ulasan. Jadilah yang pertama memberikan ulasan!</p>
        <?php endif; ?>
    </div>
</section>

<?php require_once "components/footer.php"; ?>

</body>
</html>