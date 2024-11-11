<?php
$conn = new mysqli("localhost", "root", "", "cashier");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_GET['id_penjualan'])) {
    $id_penjualan = $_GET['id_penjualan'];

    // Ambil detail dari tabel penjualan
    $sql = "SELECT p.tanggal_penjualan, p.total_harga, pl.nama_pelanggan, dp.jumlah_produk, pr.nama_produk, pr.harga, dp.bayar, dp.kembalian
            FROM penjualan p
            JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
            JOIN detailpenjualan dp ON dp.id_penjualan = p.id_penjualan
            JOIN produk pr ON dp.id_produk = pr.id_produk
            WHERE p.id_penjualan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_penjualan);
    $stmt->execute();
    $result = $stmt->get_result();

    // Inisialisasi variabel untuk total, bayar, dan kembalian
    $total_harga = $bayar = $kembalian = 0;
    
    if ($result->num_rows > 0) {
        // Mulai tampilkan struk
        echo "<div id='struk-print-area' style='
    width: 300px; 
    padding: 20px; 
    border: 1px solid #000; 
    font-family: Arial, sans-serif; 
    font-size: 14px; 
    background-color: #fff; 
    position: fixed; 
    top: 50%; 
    left: 50%; 
    transform: translate(-50%, -50%);
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);'>
";

        echo "<h3 style='text-align: center; margin-bottom: 10px;'>Struk Pembelian</h3>";
        echo "<p><strong>ID Penjualan:</strong> " . htmlspecialchars($id_penjualan) . "</p>";

        // Ambil data baris pertama untuk informasi umum
        $row = $result->fetch_assoc();
        echo "<p><strong>Tanggal:</strong> " . htmlspecialchars($row['tanggal_penjualan']) . "</p>";
        echo "<p><strong>Pelanggan:</strong> " . htmlspecialchars($row['nama_pelanggan']) . "</p>";
        
        // Tabel Daftar Produk
        echo "<table style='width: 100%; border-collapse: collapse; margin-top: 10px;'>";
        echo "<tr>
                <th style='border-bottom: 1px solid #000; padding: 5px 0;'>Produk</th>
                <th style='border-bottom: 1px solid #000; padding: 5px 0; text-align: center;'>Jumlah</th>
                <th style='border-bottom: 1px solid #000; padding: 5px 0; text-align: right;'>Harga Satuan</th>
              </tr>";
        
        // Cetak data produk dengan harga satuan
        do {
            $harga = $row['harga'];
            
            echo "<tr>
                    <td style='padding: 5px 0;'>" . htmlspecialchars($row['nama_produk']) . "</td>
                    <td style='padding: 5px 0; text-align: center;'>" . htmlspecialchars($row['jumlah_produk']) . "</td>
                    <td style='padding: 5px 0; text-align: right;'>Rp " . number_format($harga, 0, ',', '.') . "</td>
                  </tr>";

            // Simpan nilai untuk total, bayar, dan kembalian
            $total_harga = $row['total_harga'];
            $bayar = $row['bayar'];
            $kembalian = $row['kembalian'];
        } while ($row = $result->fetch_assoc());

        echo "</table>";

        // Garis pemisah
        echo "<hr style='border-top: 1px dashed #000; margin: 10px 0;'>";

        // Informasi Total Harga, Bayar, dan Kembalian
        echo "<p style='text-align: right;'><strong>Total Harga:</strong> Rp " . number_format($total_harga, 0, ',', '.') . "</p>";
        echo "<p style='text-align: right;'><strong>Bayar:</strong> Rp " . number_format($bayar, 0, ',', '.') . "</p>";
        echo "<p style='text-align: right;'><strong>Kembalian:</strong> Rp " . number_format($kembalian, 0, ',', '.') . "</p>";

       // Penutup
       echo "<p style='text-align: center; margin-top: 10px;'>Terima kasih atas kunjungan Anda!</p>";

       // Tombol Print dan Tutup
       echo "<div id='print-buttons' style='text-align: center;'>";
       echo "<button onclick='printStruk()' style='
    display: inline-block; 
    margin: 0 5px; 
    padding: 10px 20px; 
    font-size: 14px; 
    background-color: #008CBA; 
    color: white; 
    border: none; 
    border-radius: 5px; 
    cursor: pointer;
'>Print</button>";

       echo "<button onclick='closeDetailModal()' style='
    display: inline-block; 
    margin: 0 5px; 
    padding: 10px 20px; 
    font-size: 14px; 
    background-color: #4CAF50; 
    color: white; 
    border: none; 
    border-radius: 5px; 
    cursor: pointer;
'>Tutup</button>";
       echo "</div>";

        echo "</div>";

        // CSS dan JavaScript untuk print
        echo "<style>
            @media print {
                #print-buttons {
                    display: none; /* Sembunyikan tombol saat di-print */
                }
                body {
                    background-color: #fff; /* Menghilangkan efek bayangan */
                }
            }
        </style>";

        echo "<script>
            function printStruk() {
                window.print();
            }
        </script>";
    } else {
        echo "Data tidak ditemukan.";
    }

    $stmt->close();
}

$conn->close();
?>
