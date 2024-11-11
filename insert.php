<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang</title>
    <link rel="stylesheet" href="insertcss.css"> 
</head>
<body>
    <style>
        body {
            background-image: url('images/abu.jpg'); 
        background-size: cover; 
        background-position: center; 
        background-attachment: fixed; 
        }
    </style>
    <div class="navbar" style="background-color: #1c1c1c; color: white; padding: 15px 20px; position: sticky; top: 0; z-index: 1000; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <div class="navbar-logo" style="display: flex; align-items: center;">
        <img src="images/monee.png" alt="Website Logo" style="width: 44px; height: 44px; margin-right: 15px;">
        <a href="#" style="color: white; text-decoration: none; font-weight: bold; font-size: 18px;">Kasir Uqqy</a>
    </div>

    <div class="navbar-links" style="margin-left: 1100px;">
        <a href="home.php" style="color: white; text-decoration: none; font-weight: bold; font-size: 18px; margin-right: 20px; transition: color 0.3s;">Home</a>
        <a href="databarang.php" style="color: white; text-decoration: none; font-weight: bold; font-size: 18px; margin-right: 20px; transition: color 0.3s;">Data Barang</a>
        <a href="pelanggan.php" style="color: white; text-decoration: none; font-weight: bold; font-size: 18px; margin-right: 20px; transition: color 0.3s;">Data Pelanggan</a>
        <a href="penjualan.php" style="color: white; text-decoration: none; font-weight: bold; font-size: 18px; margin-right: 20px; transition: color 0.3s;">Data Penjualan</a>
    </div>

    <form method="POST" action="logout.php" class="logout-form" style="margin: 0;">
        <button type="submit" class="logout-button" style="background-color: #d9534f; color: white; border: none; padding: 10px 15px; border-radius: 5px; font-weight: bold; cursor: pointer; transition: background-color 0.3s;">Logout</button>
    </form>
</div>
<br><br>
    <div class="container">
        <div class="header">Tambah Barang</div>
        <form action="insert.php" method="POST" class="form-tambah">
            <label for="nama_produk">Nama Barang:</label>
            <input type="text" id="nama_produk" name="nama_produk" required>

            <label for="kategori">Kategori:</label>
            <input type="text" id="kategori" name="kategori" required>

            <label for="stok">Stok:</label>
            <input type="number" id="stok" name="stok" required>

            <label for="harga">Harga:</label>
            <input type="number" id="harga" name="harga" required>

            <button type="submit" name="submit" class="tambah-btn">Tambah</button>
        </form>

</body>
</html>

<?php
$conn = new mysqli("localhost", "root", "", "cashier");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $nama_produk = $_POST['nama_produk'];
    $kategori = $_POST['kategori'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];

    $sql = "INSERT INTO produk (nama_produk, kategori, stok, harga) VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $nama_produk, $kategori, $stok, $harga);

    if ($stmt->execute()) {
        header("Location: databarang.php?message=added");
        exit();
    } else {
        echo "Gagal menambahkan barang: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
