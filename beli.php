<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beli Barang di Toko Uqqy</title>
</head>
<link rel="stylesheet" href="mystyle.css">
<body>
<style>
body {
        font-family: 'Arial', sans-serif;
        background-color: #797979;
        margin: 0;
        padding: 0;
        background-image: url('images/backgroundd.jpg'); 
        background-size: cover; 
        background-position: center; 
        background-attachment: fixed; 
    }    

    .beli-btn {
    background-color: blue;
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    transition: transform 0.2s ease; 
}

.beli-btn:hover {
    animation: fold 0.6s infinite; 
}

@keyframes fold {
    0% { transform: scale(1); }
    50% { transform: scale(0.7, 1); } 
    100% { transform: scale(1); } 
}


</style>

<div class="navbar" style="background-color: #1c1c1c; color: white; padding: 15px 20px; position: sticky; top: 0; z-index: 1000; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">

<div class="navbar-logo" style="display: flex; align-items: center;">
<img src="images/monee.png" alt="Website Logo" style="width: 44px; height: 44px; margin-right: 15px;">
<a href="#" style="color: white; text-decoration: none; font-weight: bold; font-size: 18px;">Kasir Uqqy</a>
</div>

<form method="POST" action="logout.php" class="logout-form" style="margin: 0;">
<button type="submit" class="logout-button" style="background-color: #d9534f; color: white; border: none; padding: 10px 15px; border-radius: 5px; font-weight: bold; cursor: pointer; transition: background-color 0.3s;">Logout</button>
</form>
</div>
<br><br>

<div class="container" id="beli-barang">
<div class="header" style="font-size: 35px; font-weight: bold; text-align: center;">👘 Beli Barang 🎸</div>
        
        <div style="display: flex; justify-content: space-between; align-items: center;">
            
            <a href="">
                <button style="background-color: #FFFFFF;"></button>
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
<button class='beli-btn' onclick='openModal(" . $row['id_produk'] . "," . $row['stok'] . ")'>Beli</button>
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

<div id="beliModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">Pembelian Barang</div>
        <div class="modal-body">
            <label for="jumlahBeli">Jumlah Barang yang Dibeli:</label>
            <input type="number" id="jumlahBeli" min="1" max="">
        </div>
        <div class="modal-footer">
            <button class="beli-confirm" style='background-color: lime; color: black;' id="confirmBeli">Beli</button>
            <button class="cancel-btn" onclick="closeModal()">Cancel</button>
        </div>
    </div>
</div>

<script>
    let beliId = null;
    let stokBarang = null;

    function openModal(id, stok) {
        beliId = id;
        stokBarang = stok;
        document.getElementById("jumlahBeli").max = stok;
        document.getElementById("beliModal").style.display = "block";
    }

    function closeModal() {
        document.getElementById("beliModal").style.display = "none";
        beliId = null;
        stokBarang = null;
    }

    document.getElementById('confirmBeli').addEventListener('click', function() {
        const jumlahBeli = document.getElementById('jumlahBeli').value;
        
        if (jumlahBeli && beliId) {
            if (jumlahBeli <= stokBarang) {
              
                window.location.href = `prosesbeli.php?id=${beliId}&jumlah=${jumlahBeli}`;
            } else {
                alert('Jumlah barang melebihi stok yang tersedia!');
            }
        }
    });

    window.onclick = function(event) {
        if (event.target == document.getElementById('beliModal')) {
            closeModal();
        }
    }
</script>

</body>
</html>
