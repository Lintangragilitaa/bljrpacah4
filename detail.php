<?php
session_start();
require_once 'barangManager.php'; // Memanggil class BarangManager

$barangManager = new BarangManager();
$barangList = $barangManager->getBarang(); // Mendapatkan data barang dari JSON

// Mendapatkan nama produk dari URL parameter
$produkNama = isset($_GET['produk']) ? htmlspecialchars($_GET['produk']) : '';


// Mencari produk berdasarkan nama
$produkDetail = null;
foreach ($barangList as $barang) {
    if ($barang['nama'] === $produkNama) {
        $produkDetail = $barang;
        break;
    }
}

if (!$produkDetail) {
    // Jika produk tidak ditemukan, arahkan kembali ke halaman utama
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <link rel="stylesheet" href="style3.css">
</head>
<body>
    <header>
        <h1>Detail Produk</h1>
    </header>

    <div class="product-detail-container">
        <h2><?= htmlspecialchars($produkDetail['nama']) ?></h2>
        <img src="<?= htmlspecialchars($produkDetail['gambar']) ?>" alt="<?= htmlspecialchars($produkDetail['nama']) ?>" class="product-image">

        <p><strong>Deskripsi:</strong> <?= htmlspecialchars($produkDetail['deskripsi']) ?></p>
        <p><strong>Harga:</strong> Rp <?= number_format($produkDetail['harga'], 0, ',', '.') ?></p>
        <p><strong>Stok:</strong> <?= $produkDetail['stok'] > 0 ? $produkDetail['stok'] : 'Habis' ?></p>

        <a href="checkout.php?produk=<?= urlencode($produkDetail['nama']) ?>" class="checkout-button">Beli Sekarang</a>
        <a href="index.php" class="back-button">Kembali</a>
    </div>

    <footer>
        <p>&copy; 2024 Lintang Ragilita</p>
    </footer>

    <style>
        .product-detail-container {
            padding: 20px;
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .product-image {
            width: 100%;
            max-width: 500px;
            border-radius: 10px;
        }

        .checkout-button {
            background-color: #a0c4ff;
            padding: 10px 20px;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
        }

        .checkout-button:hover {
            background-color: #7cb7f7;
        }

        .back-button {
            background-color: #f5f5f5;
            color: #333;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
        }

        .back-button:hover {
            background-color: #e0e0e0;
        }
    </style>
</body>
</html>
