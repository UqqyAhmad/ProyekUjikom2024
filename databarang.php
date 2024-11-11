<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'Admin' && $_SESSION['role'] != 'Petugas')) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>
</head>
<link rel="stylesheet" href="mystyle.css">
<body>
    <style>
body {
  font-family: 'Arial', sans-serif;
  background-color: #797979;
  margin: 0;
  padding: 0;
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
<a href="databarang.php" style="color: yellow; text-decoration: none; font-weight: bold; font-size: 20px; margin-right: 20px; transition: color 0.3s;">Data Barang</a>
<a href="pelanggan.php" style="color: white; text-decoration: none; font-weight: bold; font-size: 18px; margin-right: 20px; transition: color 0.3s;">Data Pelanggan</a>
<a href="penjualan.php" style="color: white; text-decoration: none; font-weight: bold; font-size: 18px; margin-right: 20px; transition: color 0.3s;">Data Penjualan</a>
</div>

<form method="POST" action="logout.php" class="logout-form" style="margin: 0;">
<button type="submit" class="logout-button" style="background-color: #d9534f; color: white; border: none; padding: 10px 15px; border-radius: 5px; font-weight: bold; cursor: pointer; transition: background-color 0.3s;">Logout</button>
</form>
</div>

    <br><br>
    
    <div class="container" id="data-barang">
        <div class="header" style="font-size: 40px; font-weight: bold; text-align: center;">Data Barang 📦</div>
        
        <div style="display: flex; justify-content: space-between; align-items: center;">
            
            <a href="insert.php">
                <button style="background-color: #009688; color: white; border: none; padding: 10px 20px; cursor: pointer;">Tambah +</button>
            </a>
            
            <form method="GET" action="" style="display: flex; align-items: center;">
                <input type="text" name="search" placeholder="Cari Barang" style="padding: 8px; font-size: 14px;">
                <button type="submit" style="background: none; border: none; cursor: pointer;">
                    <img src="images/cari.png" alt="Cari" style="width: 24px; height: 24px;">
                </button>
            </form>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                   
                    $conn = new mysqli("localhost", "root", "", "cashier");

                    if ($conn->connect_error) {
                        die("Koneksi gagal: " . $conn->connect_error);
                    }

                    $sql = "SELECT id_produk, nama_produk, kategori, stok, harga FROM produk";

                    if (isset($_GET['search']) && !empty($_GET['search'])) {
                        $search = $_GET['search'];
                        $sql .= " WHERE nama_produk LIKE '%$search%'";
                    }

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $no = 1;
                     
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . $row["nama_produk"] . "</td>";
                            echo "<td>" . $row["kategori"] . "</td>";
                            echo "<td>" . $row["stok"] . "</td>";
                            echo "<td>Rp " . number_format($row["harga"], 0, ',', '.') . "</td>";
                            echo "<td>
                                    <a href='editbarang.php?id=" . $row['id_produk'] . "'><button class='edit-btn'>Edit</button></a>
                                    <button class='delete-btn'; onclick='openModal(" . $row['id_produk'] . ")'>Hapus</button>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Tidak ada data barang</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>

        <div id="deleteModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">Apakah anda ingin menghapus data ini?</div>
                <div class="modal-footer">
                    <button class="delete-confirm" id="confirmDelete">Delete</button>
                    <button class="cancel-btn" onclick="closeModal()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</body>

    <script>
        let deleteId = null;

        function openModal(id) {
            deleteId = id;
            document.getElementById("deleteModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("deleteModal").style.display = "none";
            deleteId = null;
        }

        document.getElementById('confirmDelete').addEventListener('click', function() {
            if (deleteId) {
                window.location.href = `deletebarang.php?id=${deleteId}`;
            }
        });

        window.onclick = function(event) {
            if (event.target == document.getElementById('deleteModal')) {
                closeModal();
            }
        }
    </script>
</html>





