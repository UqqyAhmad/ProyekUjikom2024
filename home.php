<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'Admin' && $_SESSION['role'] != 'Petugas')) {
    header("Location: login.php");
    exit();
}
?>

<?php

$role = $_SESSION['role'] ?? ''; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Kasir Uqqy</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #1b1b1b;
            color: #fff;
            background-image: url('images/gray.jpg'); 
            background-size: cover;
            background-position: center;
        }

        .header {
            text-align: center;
            padding: 310px 0;
          
            
        }

        .header h1 {
            font-size: 3em;
            margin-bottom: 20px;
        }

        .header p {
            font-size: 1.5em;
        }

        .buttons {
            margin-top: 30px;
        }

        .btn {
    background-color: #ffcc00;
    color: #000;
    padding: 15px 30px;
    border: none;
    cursor: pointer;
    font-size: 1.2em;
    margin: 0 10px;
    text-transform: uppercase;
    transition: all 0.3s ease; 
}

.btn:hover {
    background-color: #000; 
    color: #fff; 
    transform: scale(0.95); 
}


       
    </style>
</head>
<body>
<div class="navbar" style="background-color: #1c1c1c; color: white; padding: 15px 20px; position: sticky; top: 0; z-index: 1000; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
<div class="navbar-logo" style="display: flex; align-items: center;">
<img src="images/monee.png" alt="Website Logo" style="width: 44px; height: 44px; margin-right: 15px;">
<a href="#" style="color: white; text-decoration: none; font-weight: bold; font-size: 18px;">Kasir Uqqy</a>
</div>

<div class="navbar-links" style="margin-left: 1100px;">
<a href="home.php" style="color: yellow; text-decoration: none; font-weight: bold; font-size: 20px; margin-right: 20px; transition: color 0.3s;">Home</a>
<a href="databarang.php" style="color: white; text-decoration: none; font-weight: bold; font-size: 18px; margin-right: 20px; transition: color 0.3s;">Data Barang</a>
<a href="pelanggan.php" style="color: white; text-decoration: none; font-weight: bold; font-size: 18px; margin-right: 20px; transition: color 0.3s;">Data Pelanggan</a>
<a href="penjualan.php" style="color: white; text-decoration: none; font-weight: bold; font-size: 18px; margin-right: 20px; transition: color 0.3s;">Data Penjualan</a>
</div>

<form method="POST" action="logout.php" class="logout-form" style="margin: 0;">
<button type="submit" class="logout-button" style="background-color: #d9534f; color: white; border: none; padding: 10px 15px; border-radius: 5px; font-weight: bold; cursor: pointer; transition: background-color 0.3s;">Logout</button>
</form>


</div>

    <div class="header">
        <h1>KASIR UQQY</h1>
        <p>Website untuk mengelola produk, pelanggan. pembelian serta penjualan.</p>
        <p></p>
        <div class="buttons">
    <button class="btn" onclick="location.href='databarang.php'">Data Barang</button>
    <button class="btn" onclick="location.href='pelanggan.php'">Data Pelanggan</button>
    <button class="btn" onclick="location.href='penjualan.php'">Data Penjualan</button>
</div>

        <br><br>
        <div>
        <?php if ($role == 'Admin') : ?>
    <form action="tambah_user.php" method="get">
        <button type="submit" class="register-button" style="background-color: #a00094; color: white; border: none; padding: 10px 15px; border-radius: 5px; font-weight: bold; cursor: pointer; transition: background-color 0.3s;">
            Register +
        </button>
    </form>
<?php endif; ?>

</form>

        </div>
    </div>

  

</body>
</html>
