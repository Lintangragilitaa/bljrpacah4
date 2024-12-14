<?php
session_start();

// Initialize the customers session array if it's not already set
if (!isset($_SESSION['customers'])) {
    $_SESSION['customers'] = [];
}

// Initialize error and success messages
$error = $success = '';
$editingIndex = null;

// Example barang list, replace it with your actual data.
$barangList = [
    ['nama' => 'Aneka Kerajinan kayu'],
    ['nama' => 'Aneka Mug Kayu'],
    ['nama' => 'Tas Anyam'],
    ['nama' => 'Teko Tanah Liat'],
    ['nama' => 'Tirai Cangkang Kerang'],
    ['nama' => 'Kain Tenun'],
    ['nama' => 'Batik Tradisional'],
    ['nama' => 'Wayang Kulit'],
];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_customer'])) {
        // Add new customer
        $name = $_POST['name'];
        $contact = $_POST['contact'];
        $alamat = $_POST['alamat'];
        $produk = $_POST['produk'];
        $jumlah = $_POST['jumlah'];
        
        // Validation (Example)
        if (empty($name) || empty($contact) || empty($alamat) || empty($produk) || $jumlah <= 0) {
            $error = "Semua field harus diisi dengan benar!";
        } else {
            $_SESSION['customers'][] = ['name' => $name, 'contact' => $contact, 'alamat' => $alamat, 'produk' => $produk, 'jumlah' => $jumlah];
            $success = "Pelanggan berhasil ditambahkan!";
        }
    }

    // Edit customer
    if (isset($_POST['edit_customer'])) {
        $editingIndex = $_POST['edit_customer'];
    }

    // Save edited customer
    if (isset($_POST['save_customer'])) {
        $index = $_POST['save_customer'];
        $_SESSION['customers'][$index]['name'] = $_POST['name'];
        $_SESSION['customers'][$index]['contact'] = $_POST['contact'];
        $_SESSION['customers'][$index]['alamat'] = $_POST['alamat'];
        $_SESSION['customers'][$index]['produk'] = $_POST['produk'];
        $_SESSION['customers'][$index]['jumlah'] = $_POST['jumlah'];
        $success = "Perubahan berhasil disimpan!";
    }

    // Delete customer
    if (isset($_POST['delete_customer'])) {
        $index = $_POST['delete_customer'];
        unset($_SESSION['customers'][$index]);
        $_SESSION['customers'] = array_values($_SESSION['customers']); // Re-index the array
        $success = "Pelanggan berhasil dihapus!";
    }

    // Clear all customers
    if (isset($_POST['clear_customers'])) {
        $_SESSION['customers'] = [];
        $success = "Semua pelanggan berhasil dihapus!";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style1.css"> <!-- Menautkan file CSS -->
    <title>Manajemen Pelanggan</title>
</head>
<body>
    <style>
/* Reset dan gaya dasar */
* { 
    margin: 0; 
    padding: 0; 
    box-sizing: border-box; 
}
body { 
    font-family: 'Arial', sans-serif; 
    background-color: #f5f5f5; 
    color: #333; 
}

/* Gaya Header */
header { 
    background-color: #a0c4ff; 
    padding: 1rem 0; 
    color: white; 
    box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
    display: flex; 
    align-items: center; 
    justify-content: space-between; 
}
.header-content { 
    display: flex; 
    align-items: center; 
    gap: 10px; 
}
.logo { 
    width: 50px; 
    height: auto; 
}

/* Gaya Formulir */
form { 
    background-color: #ffffff; 
    padding: 20px; 
    border-radius: 10px; 
    width: 100%; 
    max-width: 500px; 
    margin: 20px auto; 
}
form input, 
form select, 
form button { 
    width: 100%; 
    padding: 10px; 
    margin-bottom: 10px; 
    border: 1px solid #ddd; 
    border-radius: 5px; 
}
form button { 
    background-color: #a0c4ff; 
    color: white; 
    border: none; 
    cursor: pointer; 
}

/* Notifikasi pesan sukses dan error */
.success, 
.error { 
    padding: 10px; 
    border-radius: 5px; 
    text-align: center; 
    margin: 10px auto; 
    max-width: 500px; 
}
.success { 
    background-color: #d4edda; 
    color: #155724; 
}
.error { 
    background-color: #f8d7da; 
    color: #721c24; 
}

/* Gaya Tabel Pelanggan */
table { 
    width: 100%; 
    max-width: 800px; 
    margin: 20px auto; 
    border-collapse: collapse; 
}
table th, 
table td { 
    padding: 10px; 
    text-align: left; 
    border: 1px solid #ddd; 
}
table th { 
    background-color: #a0c4ff; 
    color: white; 
}

/* Tombol-tombol pelanggan */
.customer-buttons button { 
    background-color: #ff4b5c; 
    color: white; 
    border: none; 
    padding: 5px; 
    border-radius: 5px; 
    font-size: 0.8rem; 
    cursor: pointer; 
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


</style>

    <!-- Header -->
    <header>
        <div class="header-content">
            <img src="assets\logo.png" alt="Logo" class="logo"> <!-- Ganti dengan logo yang sesuai -->
            <h1>Manajemen Pelanggan</h1>
        </div>
        <nav>
            <ul>
                <li><a href="dashboard.php">Home</a></li>
                <li><a href="costumer.php">Customer</a></li>
                <li><a href="index.php">Stok</a></li>
            </ul>
        </nav>
    </header>

    <!-- Pesan Error -->
    <?php if ($error): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <!-- Pesan Keberhasilan -->
    <?php if ($success): ?>
        <p class="success"><?= $success ?></p>
    <?php endif; ?>

    <!-- Form Tambah/Perbarui Pelanggan -->
    <section id="form">
        <form method="POST">
            <h2><?= $editingIndex !== null ? "Edit Pelanggan" : "Tambah Pelanggan" ?></h2>
            <label>Nama: <input type="text" name="name" value="<?= $editingIndex !== null ? $_SESSION['customers'][$editingIndex]['name'] : '' ?>" required></label><br>
            <label>Kontak: <input type="text" name="contact" value="<?= $editingIndex !== null ? $_SESSION['customers'][$editingIndex]['contact'] : '' ?>" required></label><br>
            <label>Alamat: <input type="text" name="alamat" value="<?= $editingIndex !== null ? $_SESSION['customers'][$editingIndex]['alamat'] : '' ?>" required></label><br>
            <label>Produk: 
                <select name="produk" required>
                    <?php foreach ($barangList as $barang): ?>
                        <option value="<?= $barang['nama'] ?>" <?= $editingIndex !== null && $_SESSION['customers'][$editingIndex]['produk'] === $barang['nama'] ? 'selected' : '' ?>><?= $barang['nama'] ?></option>
                    <?php endforeach; ?>
                </select>
            </label><br>
            <label>Jumlah: <input type="number" name="jumlah" min="1" value="<?= $editingIndex !== null ? $_SESSION['customers'][$editingIndex]['jumlah'] : '' ?>" required></label><br>
            <button type="submit" name="<?= $editingIndex !== null ? 'save_customer' : 'add_customer' ?>" value="<?= $editingIndex !== null ? $editingIndex : '' ?>">
                <?= $editingIndex !== null ? "Simpan Perubahan" : "Tambah Pelanggan" ?>
            </button>
        </form>
    </section>

    <!-- Daftar Pelanggan -->
    <section id="customer-list">
    <h2>Daftar Pelanggan</h2>
    <?php if (!empty($_SESSION['customers'])): ?>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Kontak</th>
                    <th>Alamat</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['customers'] as $index => $customer): ?>
                    <tr>
                        <td><?= $customer['name'] ?></td>
                        <td><?= $customer['contact'] ?></td>
                        <td><?= $customer['alamat'] ?></td>
                        <td><?= $customer['produk'] ?></td>
                        <td><?= $customer['jumlah'] ?></td>
                        <td>
                            <form method="POST" style="display: inline;">
                                <button type="submit" name="edit_customer" value="<?= $index ?>">Edit</button>
                                <button type="submit" name="delete_customer" value="<?= $index ?>">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <form method="POST" style="text-align: center;">
            <button type="submit" name="clear_customers">Hapus Semua Pelanggan</button>
        </form>
    <?php else: ?>
        <p style="text-align: center;">Tidak ada pelanggan.</p>
    <?php endif; ?>
</section>

</body>
</html>
