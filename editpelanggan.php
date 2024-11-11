<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pelanggan</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #797979;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 10px;
        }
        h2 {
            text-align: center;
            background-color: #1c1c1c;
            color: white;
            padding: 20px;
            margin: -20px -20px 20px -20px;
            border-radius: 10px 10px 0 0;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            font-weight: bold;
            margin-bottom: 10px;
        }
        input[type="text"], input[type="number"] {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            border-radius: 5px;
        }
        .save-btn {
            background-color: #242424;
            color: white;
        }
        .save-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Edit Data Pelanggan</h2>

        <?php
        $conn = new mysqli("localhost", "root", "", "cashier");

        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $sql = "SELECT * FROM pelanggan WHERE id_pelanggan = $id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $nama = $row['nama_pelanggan'];
                $alamat = $row['alamat'];
                $no_telepon = $row['no_telepon'];
            } else {
                echo "Data tidak ditemukan.";
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['id'];
            $nama = $_POST['nama_pelanggan'];
            $alamat = $_POST['alamat'];
            $no_telepon = $_POST['no_telepon'];

            $sql = "UPDATE pelanggan SET nama_pelanggan='$nama', alamat='$alamat', no_telepon=$no_telepon WHERE id_pelanggan=$id";

            if ($conn->query($sql) === TRUE) {
                echo "Data berhasil diperbarui!";
                header("Location: pelanggan.php"); 
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        $conn->close();
        ?>

        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <label for="nama">Nama Pelanggan:</label>
            <input type="text" name="nama_pelanggan" value="<?php echo $nama; ?>" required>

            <label for="nama">Alamat:</label>
            <input type="text" name="alamat" value="<?php echo $alamat; ?>" required>

            <label for="nama">No. Telepon:</label>
            <input type="text" name="no_telepon" value="<?php echo $no_telepon; ?>" required>

            <button type="submit" class="save-btn">Simpan Perubahan</button>
        </form>
    </div>

</body>
</html>
