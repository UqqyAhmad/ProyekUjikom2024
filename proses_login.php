<?php
session_start();
include 'koneksi.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT u.id, u.password, u.role_id, r.role_name 
              FROM users u 
              JOIN roles r ON u.role_id = r.id 
              WHERE u.username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
   
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role_id'] = $row['role_id'];
            $_SESSION['role_name'] = $row['role_name'];

            if ($row['role_name'] === 'Admin' || $row['role_name'] === 'Petugas') {
                header("Location: databarang.php"); 
            } else {
                header("Location: beli.php"); 
            }
            exit();
        } else {
            echo "Username atau password salah!";
        }
    } else {
        echo "Username atau password salah!";
    }
}

$stmt->close();
$conn->close();
?>
