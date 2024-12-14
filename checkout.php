<?php
session_start();
require_once 'barangManager.php'; // Memanggil class BarangManager

$barangManager = new BarangManager();
$barangList = $barangManager->getBarang(); // Mendapatkan data barang dari JSON

// Inisialisasi data pelanggan jika belum ada
if (!isset($_SESSION['customers'])) {
    $_SESSION['customers'] = [];
}

$error = null;
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    $namaPelanggan = htmlspecialchars($_POST['nama_pelanggan']);
    $alamatPengiriman = htmlspecialchars($_POST['alamat']);
    $kontakPelanggan = htmlspecialchars($_POST['kontak']); // Ambil nilai kontak dari form
    $produkDipilih = htmlspecialchars($_POST['produk']);
    $jumlahDipilih = (int)htmlspecialchars($_POST['jumlah']);

    if (!empty($namaPelanggan) && !empty($alamatPengiriman) && !empty($kontakPelanggan) && !empty($produkDipilih) && $jumlahDipilih > 0) {
        foreach ($barangList as &$barang) {
            if ($barang['nama'] === $produkDipilih) {
                if ($barang['stok'] >= $jumlahDipilih) {
                    // Kurangi stok barang
                    $barang['stok'] -= $jumlahDipilih;
                    $barangManager->updateBarang($barangList);

                    // Tambahkan ke daftar pelanggan
                    $_SESSION['customers'][] = [
                        'name' => $namaPelanggan,
                        'contact' => $kontakPelanggan, // Masukkan kontak pelanggan
                        'alamat' => $alamatPengiriman,
                        'produk' => $produkDipilih,
                        'jumlah' => $jumlahDipilih
                    ];
                    $success = "Checkout berhasil! Data pelanggan ditambahkan.";
                } else {
                    $error = "Stok tidak mencukupi untuk produk ini.";
                }
                break;
            }
        }
    } else {
        $error = "Semua bidang harus diisi dengan benar.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style3.css">
    <title>Checkout Produk</title>
</head>
<body>
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
}

h1, h2 {
    text-align: center;
    color: #333;
}

/* Header */
header {
    background-color: #a0c4ff;
    padding: 1rem 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

header img {
    width: 50px;
    height: 50px;
    margin-left: 1rem;
}

header h1 {
    font-size: 2rem;
    color: #333;
    margin-left: 0.5rem;
}

nav ul {
    display: flex;
    list-style: none;
}

nav ul li {
    margin: 0 15px;
}

nav ul li a {
    color: #333;
    text-decoration: none;
    font-weight: 600;
}

nav ul li a:hover {
    color: #ff6b6b;
}

/* Footer */
footer {
    background-color:#a0c4ff;
    color: #333;
    text-align: center;
    padding: 2rem 0;
    margin-top: 2rem;
}

footer p {
    font-size: 0.9rem;
}

/* Checkout Form */
.checkout-container {
    max-width: 800px;
    margin: 2rem auto;
    padding: 2rem;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.checkout-container h1 {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.checkout-container form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.checkout-container label {
    font-size: 1rem;
    color: #333;
}

.checkout-container input,
.checkout-container select,
.checkout-container textarea {
    padding: 0.8rem;
    font-size: 1rem;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
    transition: border 0.3s;
}

.checkout-container input:focus,
.checkout-container select:focus,
.checkout-container textarea:focus {
    border: 1px solid #74c69d;
    background-color: #fff;
}

.checkout-container button {
    background-color: #74c69d;
    color: #fff;
    font-size: 1.1rem;
    padding: 1rem;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.checkout-container button:hover {
    background-color: #40916c;
}

/* Message/Error */
.error {
    color: #ff6b6b;
    font-weight: bold;
    text-align: center;
}

.success {
    color: #74c69d;
    font-weight: bold;
    text-align: center;
}

    </style>
    <div class="checkout-container">
        <h1>Checkout</h1>
        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <?php if ($success): ?>
            <p class="success"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <form method="POST">
            <label for="nama_pelanggan">Nama Pelanggan:</label>
            <input type="text" id="nama_pelanggan" name="nama_pelanggan" required>

            <label for="kontak">Kontak</label>
            <input type="text" id="kontak" name="kontak" required>


            <label for="alamat">Alamat Pengiriman:</label>
            <textarea id="alamat" name="alamat" required></textarea>

            <label for="produk">Produk:</label>
            <select id="produk" name="produk" required>
                <?php foreach ($barangList as $barang): ?>
                    <option value="<?= htmlspecialchars($barang['nama']) ?>">
                        <?= htmlspecialchars($barang['nama']) ?> (Stok: <?= $barang['stok'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="jumlah">Jumlah Produk:</label>
            <input type="number" id="jumlah" name="jumlah" min="1" required>

            <button type="submit" name="checkout">Proses Pembayaran</button>
             <!-- Tombol Kembali -->
    <a href="dashboard.php" class="back-button">Kembali</a>
        </form>
    </div>
</body>
</html>
