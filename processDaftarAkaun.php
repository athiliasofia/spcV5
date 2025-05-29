<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_penuh = strtoupper($_POST['nama_penuh']);
    $role = $_POST['role'];
    $bengkel = $_POST['bengkel'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo "Kata laluan tidak sepadan.";
    } else {
        $check_query = "SELECT * FROM users WHERE email = '$email'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            echo "Email sudah wujud.";
        } else {
            $query = "INSERT INTO users (nama_penuh, role, bengkel, email, password) 
                      VALUES ('$nama_penuh', '$role', '$bengkel', '$email', '$password')";
            if (mysqli_query($conn, $query)) {
                echo "Pendaftaran berjaya!";
                
                if ($role == 'pelajar') {
                    header("Location: loginPelajar.php");
                } elseif ($role == 'ketua bahagian') {
                    header("Location: loginKb.php");
                } elseif ($role == 'bppl') {
                    header("Location: loginBppl.php");
                }
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>
