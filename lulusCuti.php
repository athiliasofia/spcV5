<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'bppl') {
    header('Location: index.php');
    exit();
}

$result_tpp = null;
$result_tpm = null;
$query_tpp = "SELECT * FROM permohonan_cuti_tpp WHERE status = 'Disokong'";
$query_tpm = "SELECT * FROM permohonan_cuti_tpm WHERE status = 'Disokong'";

if ($conn->query($query_tpp)) {
    $result_tpp = $conn->query($query_tpp);
} else {
    echo "Error in query for TPP: " . $conn->error;
}

if ($conn->query($query_tpm)) {
    $result_tpm = $conn->query($query_tpm);
} else {
    echo "Error in query for TPM: " . $conn->error;
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lulus Permohonan Cuti</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Lulus Permohonan Cuti</h2>
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Nama Penuh</th>
                    <th>Bengkel</th>
                    <th>Tarikh Cuti Dari</th>
                    <th>Tarikh Cuti Hingga</th>
                    <th>Bukti</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($result_tpp) {
                    while ($row = $result_tpp->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nama_penuh']); ?></td>
                            <td>TPP</td>
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
                                <a href="lulusAction.php?id=<?php echo $row['user_id']; ?>&bengkel=tpp" class="btn btn-primary">Lulus 'k'</a>
                                <a href="lulusAction.php?id=<?php echo $row['user_id']; ?>&bengkel=tpp&status=lulus0" class="btn btn-warning">Lulus '0'</a>
                                <a href="lulusAction.php?id=<?php echo $row['user_id']; ?>&bengkel=tpp&status=tolak" class="btn btn-danger">Tolak</a>
                            </td>
                        </tr>
                    <?php } 
                } ?>

                <?php 
                if ($result_tpm) {
                    while ($row = $result_tpm->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nama_penuh']); ?></td>
                            <td>TPM</td>
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
                                <a href="lulusAction.php?id=<?php echo $row['user_id']; ?>&bengkel=tpm" class="btn btn-primary">Lulus 'k'</a>
                                <a href="lulusAction.php?id=<?php echo $row['user_id']; ?>&bengkel=tpm&status=lulus0" class="btn btn-warning">Lulus '0'</a>
                                <a href="lulusAction.php?id=<?php echo $row['user_id']; ?>&bengkel=tpm&status=tolak" class="btn btn-danger">Tolak</a>
                            </td>
                        </tr>
                    <?php }
                } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
