<?php

$conn = new mysqli("localhost", "root", "", "cashier");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];

    $sql = "DELETE FROM produk WHERE id_produk = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_produk);

    if ($stmt->execute()) {
     
        header("Location: databarang.php");
        exit();
    } else {
        echo "Gagal menghapus barang: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "ID barang tidak ditemukan.";
}

$conn->close();
?>
