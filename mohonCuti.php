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
</head>
<body>
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
</body>
</html>
