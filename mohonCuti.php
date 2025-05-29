<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    if (isset($_FILES['bukti']) && $_FILES['bukti']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';  
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); 
        }
        $fileName = time() . "_" . basename($_FILES['bukti']['name']);
        $filePath = $uploadDir . $fileName;
        move_uploaded_file($_FILES['bukti']['tmp_name'], $filePath);
    } else {
        $filePath = null; 
    }

    $nama_penuh = $_POST['nama_penuh'];
    $bengkel = $_POST['bengkel'];
    $cuti_dari = $_POST['cuti_dari'];
    $cuti_hingga = $_POST['cuti_hingga'];

    $table = "permohonan_cuti_" . strtolower($bengkel);

    $stmt = $conn->prepare("INSERT INTO $table (nama_penuh, bengkel, cuti_dari, cuti_hingga, bukti, status) VALUES (?, ?, ?, ?, ?, 'Belum Disokong')");
    $stmt->bind_param("sssss", $nama_penuh, $bengkel, $cuti_dari, $cuti_hingga, $filePath);
    $stmt->execute();

    $emailKetua = '';
    switch (strtolower($bengkel)) {
        case 'tpp':
            $emailKetua = "ketua_tpp@domain.com";
            break;
        case 'tpm':
            $emailKetua = "ketua_tpm@domain.com";
            break;
        case 'tkr':
            $emailKetua = "ketua_tkr@domain.com";
            break;
        case 'cadds':
            $emailKetua = "ketua_cadds@domain.com";
            break;
    }

    $subject = "Permohonan Cuti Baru";
    $message = "Terdapat permohonan cuti baru daripada pelajar $nama_penuh di bengkel $bengkel yang memerlukan tindakan anda.";
    mail($emailKetua, $subject, $message, "From: 23223055ilpkls@gmail.com");

    echo "Permohonan cuti berjaya dihantar! Email telah dihantar kepada Ketua Bahagian.";
}
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Mohon Cuti</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f2f5fa;
            margin: 0;
            padding: 0;
        }

        .form-container {
            max-width: 500px;
            margin: 60px auto;
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #10266F;
            margin-bottom: 30px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #10266F;
        }

        input[type="text"],
        input[type="date"],
        input[type="file"],
        select,
        textarea {
            width: 100%;
            padding: 12px 14px;
            margin-bottom: 20px;
            border: 1px solid #ccd6e0;
            border-radius: 10px;
            background-color: #fff;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #10266F;
            outline: none;
            box-shadow: 0 0 0 3px rgba(16, 38, 111, 0.15);
        }

        button {
            width: 100%;
            background-color: #10266F;
            color: white;
            padding: 14px;
            font-size: 16px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0d1e59;
        }

        .message {
            text-align: center;
            margin-bottom: 20px;
            padding: 12px;
            border-radius: 10px;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        @media (max-width: 600px) {
            .form-container {
                margin: 30px 20px;
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
    <h2>Mohon Cuti</h2>
    <form method="post" enctype="multipart/form-data">
        Nama Penuh: <input type="text" name="nama_penuh" required><br>
        Bengkel: 
        <select name="bengkel" required>
            <option value="TPP">TPP</option>
            <option value="TPM">TPM</option>
            <option value="TKR">TKR</option>
            <option value="CADDS">CADDS</option>
        </select><br>
        Tarikh Cuti Dari: <input type="date" name="cuti_dari" required><br>
        Tarikh Cuti Hingga: <input type="date" name="cuti_hingga" required><br>
        Bukti: <input type="file" name="bukti"><br>
        <button type="submit">Mohon Cuti</button>
    </form>
    </div>
</body>
</html>
