<?php
// Membaca data dari file JSON
$barangJson = file_get_contents('data.json');
$barangList = json_decode($barangJson, true);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
    <link rel="stylesheet" href="style.css">
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

    /* Kontainer Utama */
    .container {
        padding: 2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 2rem 1rem;
    }

    /* Katalog Produk */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
        width: 100%;
        justify-items: center;
    }

    /* Kartu Produk */
    .product-card {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        padding: 1rem;
        width: 100%;
        max-width: 350px;
        text-align: center;
        transition: transform 0.3s;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .product-card:hover {
        transform: translateY(-5px);
    }

    .product-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 1rem;
    }

    .product-card h3 {
        font-size: 1.2rem;
        margin: 10px 0;
        color: #333;
        font-weight: 600;
    }

    .product-card p {
        font-size: 1rem;
        color: #666;
        margin-bottom: 10px;
    }

    .product-card a {
        display: inline-block;
        background-color: #74c69d;
        color: white;
        font-size: 1rem;
        padding: 0.7rem 1.2rem;
        margin: 10px 0;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .product-card a:hover {
        background-color: #40916c;
    }

    /* Footer */
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
    <!-- Navbar -->
    <header>
        <div style="display: flex; align-items: center;">
            <img src="assets/logo.png" alt="Logo">
            <h1>SerbaLokal</h1>
        </div>
        <nav>
            <ul>
                <li><a href="dashboard.php">Home</a></li>
                <li><a href="costumer.php">Customer</a></li>
                <li><a href="index.php">Stok</a></li>
            </ul>
        </nav>
    </header>

    <!-- Konten Utama -->
    <div class="container">
        <h2>Daftar Produk</h2>
        <div class="product-grid">
            <?php if (!empty($barangList)): ?>
                <?php foreach ($barangList as $barang): ?>
                    <div class="product-card">
                        <!-- Gambar produk -->
                        <img src="<?= htmlspecialchars($barang['gambar']) ?>" alt="<?= htmlspecialchars($barang['nama']) ?>">
                        <div class="product-info">
                            <h3><?= htmlspecialchars($barang['nama']) ?></h3>
                            <?php 
                                // Pastikan harga adalah angka
                                $harga = str_replace('Rp ', '', $barang['harga']); // Hapus simbol Rp jika ada
                                $harga = str_replace('.', '', $harga); // Hapus titik pemisah ribuan jika ada
                                $harga = (float)$harga; // Ubah menjadi angka
                            ?>
                            <p>Harga: Rp <?= number_format($harga, 0, ',', '.') ?></p>
                            <p>Stok: <?= htmlspecialchars($barang['stok']) ?></p>
                            <!-- Tombol beli dengan link ke halaman checkout -->
                            <a href="detail.php?produk=<?= urlencode($barang['nama']) ?>">Lihat Detail</a>

                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Belum ada barang tersedia.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Lintang Ragilita.</p>
    </footer>
</body>
</html>
