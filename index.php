<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Permohonan Cuti ILP</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css"> 
    <style>
        body {
            background-color: #f8f9fa;
            background-image: url('background-image.jpg'); 
            background-size: cover;
            background-position: center;
        }
        .hero {
            background-color: rgba(255, 255, 255, 0.9); 
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            margin-top: 100px;
        }
        h1 {
            color: #10266F; 
        }
        .btn-custom {
            background-color: #ED681D;
            border: none;
            color: white;
            transition: background-color 0.3s, transform 0.2s;
        }
        .btn-custom:hover {
            background-color: #d8621a; 
            transform: scale(1.05); 
        }
        .btn-custom i {
            margin-right: 8px; 
        }
    </style>
</head>
<body>
    <div class="container text-center hero">
        <p class="lead">Siapakah anda?</p>
        <div class="mt-4">
            <a href="loginPelajar.php" class="btn btn-custom btn-lg mx-2">
                <i class="fas fa-user-graduate"></i> Pelajar
            </a>
            <a href="loginKb.php" class="btn btn-custom btn-lg mx-2">
                <i class="fas fa-chalkboard-teacher"></i> Ketua Bahagian
            </a>
            <a href="loginBppl.php" class="btn btn-custom btn-lg mx-2">
                <i class="fas fa-users-cog"></i> BPPL
            </a>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <?php include('footer.php'); ?>
</body>
</html>
