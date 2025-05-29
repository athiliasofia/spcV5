<?php
include('db.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password' AND role = 'bppl'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['email'] = $row['email'];
        $_SESSION['nama_penuh'] = $row['nama_penuh'];
        $_SESSION['bengkel'] = $row['bengkel'];
        $_SESSION['role'] = 'ketua bahagian';
        header("Location: sokongCuti.php");
    } else {
        echo "Login gagal. Sila cuba lagi.";
    }
}
?>
