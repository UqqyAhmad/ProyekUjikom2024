<?php
$conn = new mysqli("localhost", "root", "", "cashier");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];

    $sql = "DELETE FROM penjualan WHERE id_penjualan = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_produk);

    if ($stmt->execute()) {
        header("Location: penjualan.php");
        exit();
    } else {
        echo "Gagal menghapus data: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "ID penjualan tidak ditemukan.";
}

$conn->close();
?>
