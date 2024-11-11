<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Selesai</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #797979;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        .container {
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .message {
            font-size: 32px;
            font-weight: bold;
            margin-right: 20px;
        }
        .image {
            max-width: 50%;
        }
        .image img {
            width: 100%;
            height: auto;
            max-height: 300px;
            border-radius: 8px;
        }
        .kembali-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .kembali-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="message">
            Terima Kasih Sudah Belanja di Toko Kami!<br>
            Semoga Kamu Puas!
        </div>
        <div class="image">
            <img src="images/risu.png" alt="Terima Kasih">
        </div>
    </div>

    <a href="beli.php" class="kembali-btn">Kembali</a>

</body>
</html>
