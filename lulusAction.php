<?php
session_start();
include('db.php');

if (!isset($_GET['id']) || !isset($_GET['bengkel'])) {
    echo "ID atau bengkel tidak ditentukan.";
    exit();
}

$id = $_GET['id'];
$bengkel = $_GET['bengkel'];

$table = "permohonan_cuti_" . strtolower($bengkel);
$query = "UPDATE $table SET status = 'Diluluskan oleh BPPL' WHERE user_id = ?"; 
$stmt = $conn->prepare($query);
if ($stmt) {
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $emailQuery = "SELECT email FROM permohonan_cuti_" . strtolower($bengkel) . " WHERE user_id = ?";
        $emailStmt = $conn->prepare($emailQuery);
        $emailStmt->bind_param("i", $id);
        $emailStmt->execute();
        $emailResult = $emailStmt->get_result();

        if ($emailResult->num_rows > 0) {
            $row = $emailResult->fetch_assoc();
            $pelajarEmail = $row['email']; 
        } else {
            echo "Email pelajar tidak dijumpai.";
            exit();
        }

        $subject = "Permohonan Cuti Diluluskan oleh BPPL";
        $message = "Permohonan cuti anda telah diluluskan oleh BPPL. Sila rujuk sistem untuk maklumat lanjut.";
        if (mail($pelajarEmail, $subject, $message, "From: 23223055ilpkls@gmail.com")) {
            echo "Permohonan telah diluluskan dan notifikasi telah dihantar kepada Pelajar.";
        } else {
            echo "Permohonan diluluskan, tetapi terdapat ralat dalam menghantar notifikasi.";
        }
    } else {
        echo "Ralat dalam meluluskan permohonan: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Ralat dalam penyediaan query: " . $conn->error;
}

$conn->close();
?>
