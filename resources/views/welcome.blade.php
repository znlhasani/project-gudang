<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StoreIT Inventory App Based On Website </title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <style>
        body {
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            background: linear-gradient(135deg, #001f3f, #003366); /* Navy Gradient */
            color: #fff;
        }
        .logo img {
            max-width: 220px;
            background: #fff;
            padding: 10px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }
        .btn-start {
            margin-top: 25px;
            padding: 12px 30px;
            font-size: 18px;
            font-weight: bold;
            color: #001f3f;
            background: #fff; /* Kuning emas */
            border-radius: 30px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }
        .btn-start:hover {
            background: #e6c200; /* Kuning lebih gelap */
            color: #fff;
        }
    </style>
</head>
<body>

    <!-- Logo -->
    <div class="logo text-center mb-4">
        <img src="{{ asset('logo-storeit.png') }}" alt="STOREIT Inventory System Based On Website">
    </div>

    <!-- Tombol -->
    <a href="{{ route('login') }}" class="btn-start">
        Klik di sini
    </a>

    <!-- Bootstrap JS (opsional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
