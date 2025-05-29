<?php
session_start();
include('db.php');

if ($_SESSION['role'] != 'ketua bahagian') {
    header('Location: sokongCuti.php');
    exit();
}

$query = "SELECT * FROM permohonan_cuti_tpp WHERE status = 'Belum Disokong'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Sokong Permohonan Cuti</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Senarai Permohonan Cuti untuk Disokong</h2>
        <table>
            <tr>
                <th>Nama Penuh</th>
                <th>Bengkel</th>
                <th>Tarikh Cuti Dari</th>
                <th>Tarikh Cuti Hingga</th>
                <th>Bukti</th>
                <th>Tindakan</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nama_penuh']); ?></td>
                    <td><?php echo htmlspecialchars($row['bengkel']); ?></td>
                    <td><?php echo htmlspecialchars($row['cuti_dari']); ?></td>
                    <td><?php echo htmlspecialchars($row['cuti_hingga']); ?></td>
                    <td>
                        <?php if (!empty($row['bukti'])): ?>
                            <a href="<?php echo htmlspecialchars($row['bukti']); ?>" target="_blank">Lihat Bukti</a>
                        <?php else: ?>
                            Tiada Bukti
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="sokongAction.php?id=<?php echo $row['user_id']; ?>&bengkel=<?php echo strtolower($row['bengkel']); ?>" class="btn btn-primary">Sokong</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
