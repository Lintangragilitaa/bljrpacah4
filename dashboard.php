<?php
// home.php
session_start();
require_once 'BarangManager.php'; // Pastikan file BarangManager.php sudah ada dan sesuai

$barangManager = new BarangManager();
$barangList = $barangManager->getBarang(); // Mendapatkan data barang dari JSON
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style2.css">
</head>
<style>
    /* Reset CSS */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Roboto', sans-serif;
        line-height: 1.6;
        background-color: #f5f5f5;
        color: #333;
        overflow-x: hidden;
    }

    /* Header dan Navbar */
    header {
        background-color: #a0c4ff;
        padding: 1rem 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    header img {
        width: 50px;
        height: 50px;
        margin-left: 1rem;
    }

    header h1 {
        font-size: 2rem;
        font-weight: 700;
        letter-spacing: 2px;
        color: #333;
        display: inline-block;
        margin-left: 0.5rem;
    }

    nav ul {
        display: flex;
        justify-content: center;
        list-style: none;
    }

    nav ul li {
        margin: 0 15px;
    }

    nav ul li a {
        color: #333;
        text-decoration: none;
        font-size: 1rem;
        font-weight: 600;
        transition: color 0.3s;
    }

    nav ul li a:hover {
        color: #ff6b6b;
    }

    /* Gabungan Box Katalog Barang dan Iklan */
    .container {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        margin: 2rem 1rem;
    }

    /* Menampilkan Teks Selamat Datang di Atas Katalog */
    .welcome-text {
        width: 100%;
        text-align: center;
        padding: 1rem;
    }

    .catalog {
        width: 70%;
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }

    .ad-box {
        width: 28%;
        background-color: #a0c4ff;
        padding: 1rem;
        border-radius: 10px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        gap: 15px; /* Menambahkan jarak antar iklan */
        margin-top: 1rem;
    }

    .ad-box img {
        width: 100%;
        border-radius: 10px;
    }

    .product-card {
        background-color: #f1f1f1;
        width: 200px;
        border-radius: 10px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        margin: 15px;
        overflow: hidden;
        text-align: center;
        transition: transform 0.3s;
    }

    .product-card:hover {
        transform: translateY(-5px);
    }

    .product-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .product-card h3 {
        font-size: 1.2rem;
        margin: 10px 0;
        color: #333;
    }

    .product-card p {
        font-size: 0.9rem;
        color: #666;
    }

    .product-card a {
        display: inline-block;
        background-color: #74c69d;
        color: white;
        font-size: 1rem;
        padding: 0.5rem 1rem;
        margin: 10px 0;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .product-card a:hover {
        background-color: #40916c;
    }

    footer {
        background-color: #a0c4ff;
        color: #333;
        text-align: center;
        padding: 2rem 0;
        margin-top: 2rem;
    }

    footer p {
        font-size: 0.9rem;
    }
</style>
<body>

    <header>
        <div style="display: flex; align-items: center;">
            <img src="assets/logo.png" alt="Logo">
            <h1>SerbaLokal</h1>
        </div>
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="costumer.php">Customer</a></li>
                <li><a href="index.php">Stok</a></li>
            </ul>
        </nav>
    </header>

    <!-- Teks Selamat Datang -->
    <section class="welcome-text">
        <h2>Selamat Datang di SerbaLokal!</h2>
        <p>
            Kami adalah platform yang menjual produk UMKM tradisional kerajinan tangan dari berbagai warga lokal. 
            Temukan berbagai macam barang unik dan kreatif yang dihasilkan oleh pengrajin lokal dari berbagai daerah di Indonesia. 
            Dukung produk-produk UMKM dengan membeli langsung dari para pengrajinnya, dan rasakan kehangatan dari setiap karya tangan yang penuh makna.
        </p>
    </section>

    <!-- Gabungan Box Katalog Barang dan Iklan -->
    <div class="container">
        <!-- Iklan di Kiri -->
        <div class="ad-box">
            <img src="assets/iklan1.jpg" alt="Iklan 1">
            <img src="assets/iklan2.jpg" alt="Iklan 2">
            <img src="assets/iklan3.jpg" alt="Iklan 3">
            <img src="assets/iklan4.jpg" alt="Iklan 3">
        </div>

        <!-- Katalog Barang di Kanan -->
        <div class="catalog">
            <?php foreach($barangList as $barang): ?>
                <div class="product-card">
                    <img src="<?php echo $barang['gambar']; ?>" alt="<?php echo $barang['nama']; ?>">
                    <h3><?php echo $barang['nama']; ?></h3>
                    <p>Rp <?php echo number_format($barang['harga'], 0, ',', '.'); ?></p>
                    <a href="checkout.php?id=<?php echo $barang['id']; ?>">Beli</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Lintang Ragilita.</p>
    </footer>
</body>
</html>
