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
    <title>Data Penjualan</title>
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
<a href="databarang.php" style="color: white; text-decoration: none; font-weight: bold; font-size: 18px; margin-right: 20px; transition: color 0.3s;">Data Barang</a>
<a href="pelanggan.php" style="color: white; text-decoration: none; font-weight: bold; font-size: 18px; margin-right: 20px; transition: color 0.3s;">Data Pelanggan</a>
<a href="penjualan.php" style="color: yellow; text-decoration: none; font-weight: bold; font-size: 20px; margin-right: 20px; transition: color 0.3s;">Data Penjualan</a>
</div>

<form method="POST" action="logout.php" class="logout-form" style="margin: 0;">
<button type="submit" class="logout-button" style="background-color: #d9534f; color: white; border: none; padding: 10px 15px; border-radius: 5px; font-weight: bold; cursor: pointer; transition: background-color 0.3s;">Logout</button>
</form>

</div>

    <br><br>
    <div class="container" id="data-barang">
        <div class="header" style="font-size: 40px; font-weight: bold; text-align: center;">Data Penjualan 🧾</div>
   
        <div style="display: flex; justify-content: space-between; align-items: center;">
       
            <a href="insert2.php">
                <button style="background-color: #009688; color: white; border: none; padding: 10px 20px; cursor: pointer;">Tambah +</button>
            </a>
     
            <form method="GET" action="" style="display: flex; align-items: center;">
                <input type="text" name="search" placeholder="Cari Data" style="padding: 8px; font-size: 14px;">
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
                        <th>Tanggal</th>
                        <th>Total Harga</th>
                        <th>ID Pelanggan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php                 
                    $conn = new mysqli("localhost", "root", "", "cashier");

                    if ($conn->connect_error) {
                        die("Koneksi gagal: " . $conn->connect_error);
                    }

                    $sql = "SELECT id_penjualan, tanggal_penjualan, total_harga, id_pelanggan FROM penjualan";

                    if (isset($_GET['search']) && !empty($_GET['search'])) {
                        $search = $_GET['search'];
                        $sql .= " WHERE tanggal_penjualan LIKE '%$search%'";
                    }

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $no = 1;
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . $row["tanggal_penjualan"] . "</td>";
                            echo "<td>Rp " . number_format($row["total_harga"], 0, ',', '.') . "</td>";
                            echo "<td>" . $row["id_pelanggan"] . "</td>";
                            echo "<td>
                                    <button class='delete-btn'; onclick='openModal(" . $row['id_penjualan'] . ")'>Hapus</button>
                                    <button class='detail-btn'; onclick='openDetailModal(" . $row['id_penjualan'] . ")'>Detail</button>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Tidak ada data</td></tr>";
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

     <!-- Modal Detail -->
        <div id="detailModal" class="modal">
            <div class="">             
                <div id="detailContent">Memuat data...</div>
                
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
                window.location.href = `deletepenjualan.php?id=${deleteId}`;
            }
        });

        window.onclick = function(event) {
            if (event.target == document.getElementById('deleteModal')) {
                closeModal();
            }
        }

   
    </script>

<script>
        function openDetailModal(id_penjualan) {
            const modal = document.getElementById('detailModal');
            const detailContent = document.getElementById('detailContent');

            // Tampilkan modal dan reset isi
            modal.style.display = "flex";
            detailContent.innerHTML = "Memuat data...";

            // Mengambil detail data menggunakan AJAX
            fetch(`getDetail.php?id_penjualan=${id_penjualan}`)
                .then(response => response.text())
                .then(data => {
                    detailContent.innerHTML = data;
                })
                .catch(error => {
                    detailContent.innerHTML = "Gagal memuat data.";
                });
        }

        function closeDetailModal() {
            document.getElementById('detailModal').style.display = "none";
        }
    </script>

<script>
    function printStruk() {
        // Ambil konten dari elemen struk-print-area di modal
        const strukContent = document.getElementById('struk-print-area').innerHTML;

        // Buat jendela baru untuk mencetak
        const printWindow = window.open('', '_blank', 'width=600,height=400');
        
        printWindow.document.write(`
            <html>
            <head>
                <title>Cetak Struk</title>
                <style>
                    body { font-family: Arial, sans-serif; }
                    .struk-content { width: 300px; padding: 20px; border: 1px solid #000; margin: auto; }
                </style>
            </head>
            <body>
                <div class="struk-content">
                    ${strukContent}
                </div>
            </body>
            </html>
        `);

        printWindow.document.close(); // Tutup dokumen untuk memicu rendering
        printWindow.print(); // Print isi jendela
    }
</script>

</html>





