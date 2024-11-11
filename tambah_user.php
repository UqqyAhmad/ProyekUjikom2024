<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashed_password, $role);

    if ($stmt->execute()) {
        echo "<div class='success-message'>Pengguna berhasil ditambahkan!</div>";
    } else {
        echo "<div class='error-message'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
}
?>

<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'Admin')) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #797979;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 40%;
            margin: 50px auto;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border-radius: 10px;
            padding: 20px;
        }

        .header {
            background-color: #1c1c1c;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 24px;
            border-bottom: 3px solid #f2f2f2;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: bold;
            color: #333;
        }

        input[type="text"], input[type="password"], select {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
        }

        input[type="submit"] {
            background-color: #009688;
            color: white;
            padding: 10px;
            font-size: 18px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #00796b;
        }

        .back-button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            display: inline-block;
            transition: background-color 0.3s;
        }

        .back-button:hover {
            background-color: #0056b3;
        }

        .success-message, .error-message {
            background-color: #4caf50;
            color: white;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            text-align: center;
        }

        .error-message {
            background-color: #f44336;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">Tambah Pengguna</div>
        <br>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <label for="role">Role:</label>
            <select name="role" id="role" required>
                <option value="Admin">Admin</option>
                <option value="Petugas">Petugas</option>
                <option value="Pembeli">Pembeli</option>
            </select>

            <div class="buttons">
                <input type="submit" value="Tambah Pengguna">
                <a href="home.php" class="back-button">Kembali</a>
            </div>
        </form>
    </div>

</body>
</html>
