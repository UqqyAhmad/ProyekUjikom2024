<?php
$conn = new mysqli("localhost", "root", "", "cashier");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $tanggal_penjualan = $_POST['tanggal_penjualan'];
    $id_pelanggan = $_POST['id_pelanggan'];
    $id_produk = $_POST['id_produk'];
    $jumlah_barang = $_POST['jumlah_barang'];
    $total_harga = $_POST['total_harga'];
    $anggaran = $_POST['anggaran'];
    $kembalian = $anggaran - $total_harga;

    // Validasi jika anggaran kurang dari total harga
    if ($anggaran < $total_harga) {
        echo "<p style='color: red; text-align: center;'>Uangnya Ga cukup MAANGGGGG!!!</p>";
    } else {
        // Proses penyimpanan data jika anggaran cukup
        $sql = "INSERT INTO penjualan (tanggal_penjualan, total_harga, id_pelanggan) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sis", $tanggal_penjualan, $total_harga, $id_pelanggan);

        if ($stmt->execute()) {
            $id_penjualan = $conn->insert_id;

            $subtotal = $total_harga;
            $sql_detail = "INSERT INTO detailpenjualan (id_penjualan, id_produk, jumlah_produk, subtotal, bayar, kembalian) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt_detail = $conn->prepare($sql_detail);
            $stmt_detail->bind_param("iiiddi", $id_penjualan, $id_produk, $jumlah_barang, $subtotal, $anggaran, $kembalian);

            if (!$stmt_detail->execute()) {
                echo "Gagal memasukkan data detailpenjualan: " . $conn->error;
            }

            $sql_update_stok = "UPDATE produk SET stok = stok - ? WHERE id_produk = ?";
            $stmt_update = $conn->prepare($sql_update_stok);
            $stmt_update->bind_param("ii", $jumlah_barang, $id_produk);
            $stmt_update->execute();

            header("Location: penjualan.php?message=added");
            exit();
        } else {
            echo "Gagal menambahkan data penjualan: " . $conn->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Penjualan</title>
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
        <div class="header">Tambah Penjualan</div>

        <form id="formTambah" action="" method="POST" class="form-tambah">
            <label for="tanggal_penjualan">Tanggal Penjualan:</label>
            <input type="date" id="tanggal_penjualan" name="tanggal_penjualan" required>

            <label for="id_pelanggan">Pembeli:</label>
            <select id="id_pelanggan" name="id_pelanggan" required>
                <option value="">Pilih Pelanggan</option>
                <?php
                $conn = new mysqli("localhost", "root", "", "cashier");

                if ($conn->connect_error) {
                    die("Koneksi gagal: " . $conn->connect_error);
                }

                $sql = "SELECT id_pelanggan, nama_pelanggan FROM pelanggan";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id_pelanggan'] . "'>" . $row['nama_pelanggan'] . "</option>";
                    }
                }
                ?>
            </select>

            <label for="id_produk">Barang:</label>
            <select id="id_produk" name="id_produk" required>
                <option value="">Pilih Barang</option>
                <?php
                $sql = "SELECT id_produk, nama_produk, harga, stok FROM produk";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id_produk'] . "' data-harga='" . $row['harga'] . "' data-stok='" . $row['stok'] . "'>" . $row['nama_produk'] . " (Rp " . number_format($row['harga'], 0, ',', '.') . ")</option>";
                    }
                }
                ?>
            </select>

            <label for="jumlah_barang">Jumlah Barang:</label>
            <input type="number" id="jumlah_barang" name="jumlah_barang" required>

            <label for="total_harga">Total Harga:</label>
            <input type="text" id="total_harga" name="total_harga" readonly>

            <label for="anggaran">Anggaran:</label>
            <input type="number" id="anggaran" name="anggaran" required>

            <label for="kembalian">Kembalian:</label>
            <input type="text" id="kembalian" name="kembalian" readonly>

            <button type="submit" name="submit" class="tambah-btn">Tambah</button>

            <!-- Peringatan jika stok barang tidak cukup atau uang tidak cukup -->
            <p id="stokWarning" style="color: red; display: none; text-align: center;">Transaksi tidak bisa dilakukan. Stok barang tidak cukup!</p>
            <p id="warning" style="color: red; display: none; text-align: center;">Uangnya Ga cukup MAANGGGGG!!!</p>
        </form>
    </div>

    <script>
        document.getElementById('jumlah_barang').addEventListener('input', function () {
            const selectedBarang = document.getElementById('id_produk');
            const harga = selectedBarang.options[selectedBarang.selectedIndex].getAttribute('data-harga');
            const stok = selectedBarang.options[selectedBarang.selectedIndex].getAttribute('data-stok');
            const jumlah = parseInt(this.value);
            const total = harga * jumlah;
            document.getElementById('total_harga').value = total;

            // Validasi stok barang
            if (jumlah > stok) {
                document.getElementById('stokWarning').style.display = 'block';
            } else {
                document.getElementById('stokWarning').style.display = 'none';
            }
        });

        document.getElementById('formTambah').addEventListener('submit', function (event) {
            const total = parseFloat(document.getElementById('total_harga').value) || 0;
            const anggaran = parseFloat(document.getElementById('anggaran').value) || 0;
            const kembalian = anggaran - total;
            const selectedBarang = document.getElementById('id_produk');
            const stok = selectedBarang.options[selectedBarang.selectedIndex].getAttribute('data-stok');
            const jumlah = parseInt(document.getElementById('jumlah_barang').value) || 0;

            // Cegah submit jika stok barang tidak cukup
            if (jumlah > stok) {
                event.preventDefault();
                document.getElementById('stokWarning').style.display = 'block';
            }

            // Cegah submit jika anggaran kurang
            if (anggaran < total) {
                event.preventDefault();
                document.getElementById('warning').style.display = 'block';
            }
        });
    </script>
</body>
</html>
