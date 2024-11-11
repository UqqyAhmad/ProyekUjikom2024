<?php
$conn = mysqli_connect("localhost", "root", "", "cashier");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $nama_pelanggan = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_telepon = $_POST['no_telepon'];
    $role = 'Pembeli';

    $sql_users = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
    if (mysqli_query($conn, $sql_users)) {
    
        $sql_pelanggan = "INSERT INTO pelanggan (nama_pelanggan, alamat, no_telepon) VALUES ('$nama_pelanggan', '$alamat', '$no_telepon')";
        if (mysqli_query($conn, $sql_pelanggan)) {
            header("Location: daftar_berhasil.php?nama=" . urlencode($nama_pelanggan));
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #333;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-image: url('images/backgroundd.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .container {
            background-color: #444;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            width: 300px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
        }
        input[type="text"],
        input[type="password"] {
            width: 94%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background-color: #555;
            color: #fff;
        }
        input[type="submit"] {
            background-color: #888;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Masuk</h2>
        <form action="tambah_pel.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="text" name="nama" placeholder="Nama" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="text" name="alamat" placeholder="Alamat">
            <input type="text" name="no_telepon" placeholder="No Telepon">
            <input type="submit" value="Daftar">
        </form>
    </div>
</body>
</html>
