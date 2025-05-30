<?php
session_start();
include('db.php');

$id = $_GET['id'];
$bengkel = $_GET['bengkel'];
$table = "permohonan_cuti_" . strtolower($bengkel);
$query = "UPDATE $table SET status = 'Disokong oleh Ketua Bahagian' WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$bpplEmail = "bppl@domain.com";
$subject = "Permohonan Cuti Disokong oleh Ketua Bahagian";
$message = "Permohonan cuti telah disokong oleh Ketua Bahagian dan menunggu kelulusan anda.";
mail($bpplEmail, $subject, $message, "From: 23223055ilpkls@gmail.com");

echo "Permohonan telah disokong dan notifikasi telah dihantar kepada BPPL.";
?>