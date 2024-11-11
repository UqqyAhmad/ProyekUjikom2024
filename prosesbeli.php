<?php
$conn = new mysqli("localhost", "root", "", "cashier");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id_produk = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$jumlah = isset($_GET['jumlah']) ? (int)$_GET['jumlah'] : 0;
$id_pelanggan = 12; 

if ($id_produk > 0 && $jumlah > 0) {
    $sql_produk = "SELECT harga, stok FROM produk WHERE id_produk = $id_produk";
    $result_produk = $conn->query($sql_produk);

    if ($result_produk->num_rows > 0) {
        $row_produk = $result_produk->fetch_assoc();
        $harga = $row_produk['harga'];
        $stok = $row_produk['stok'];

        if ($jumlah <= $stok) {
            $total_harga = $harga * $jumlah;
            $tanggal_penjualan = date('Y-m-d'); 

            $sql_penjualan = "INSERT INTO penjualan (tanggal_penjualan, total_harga, id_pelanggan) VALUES ('$tanggal_penjualan', $total_harga, $id_pelanggan)";
            if ($conn->query($sql_penjualan) === TRUE) {
                $id_penjualan = $conn->insert_id; // Dapatkan ID dari penjualan yang baru saja dimasukkan
                
                // Masukkan data ke tabel detailpenjualan
                $subtotal = $harga * $jumlah;
                $sql_detail = "INSERT INTO detailpenjualan (id_penjualan, id_produk, jumlah_produk, subtotal) 
                               VALUES ($id_penjualan, $id_produk, $jumlah, $subtotal)";
                if (!$conn->query($sql_detail)) {
                    echo "Gagal memasukkan data detailpenjualan: " . $conn->error;
                }

                // Update stok produk
                $stok_baru = $stok - $jumlah;
                $sql_update_stok = "UPDATE produk SET stok = $stok_baru WHERE id_produk = $id_produk";
                $conn->query($sql_update_stok);

                header("Location: selesai.php?status=success");
                exit();
            } else {
                echo "Gagal memasukkan data penjualan: " . $conn->error;
            }
        } else {
            echo "Jumlah pembelian melebihi stok tersedia.";
        }
    } else {
        echo "Produk tidak ditemukan.";
    }
} else {
    echo "Data pembelian tidak valid.";
}

$conn->close();
?>
