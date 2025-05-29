<?php
session_start();
include('db.php');

$query_tpp = "SELECT nama_penuh, 'TPP' AS bengkel, cuti_dari, cuti_hingga, status FROM permohonan_cuti_tpp";
$query_tpm = "SELECT nama_penuh, 'TPM' AS bengkel, cuti_dari, cuti_hingga, status FROM permohonan_cuti_tpm";
$query_tkr = "SELECT nama_penuh, 'TKR' AS bengkel, cuti_dari, cuti_hingga, status FROM permohonan_cuti_tkr";
$query_cadds = "SELECT nama_penuh, 'CADDS' AS bengkel, cuti_dari, cuti_hingga, status FROM permohonan_cuti_cadds";

$result_tpp = $conn->query($query_tpp);
$result_tpm = $conn->query($query_tpm);
$result_tkr = $conn->query($query_tkr);
$result_cadds = $conn->query($query_cadds);

$all_results = array_merge(
    $result_tpp ? $result_tpp->fetch_all(MYSQLI_ASSOC) : [],
    $result_tpm ? $result_tpm->fetch_all(MYSQLI_ASSOC) : [],
    $result_tkr ? $result_tkr->fetch_all(MYSQLI_ASSOC) : [],
    $result_cadds ? $result_cadds->fetch_all(MYSQLI_ASSOC) : []
);
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Permohonan Cuti</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Status Permohonan Cuti</h2>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Nama Penuh</th>
                    <th>Bengkel</th>
                    <th>Tarikh Cuti Dari</th>
                    <th>Tarikh Cuti Hingga</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($all_results as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nama_penuh']); ?></td>
                        <td><?php echo htmlspecialchars($row['bengkel']); ?></td>
                        <td><?php echo htmlspecialchars($row['cuti_dari']); ?></td>
                        <td><?php echo htmlspecialchars($row['cuti_hingga']); ?></td>
                        <td>
                            <?php
                                if ($row['status'] === 'lulus_k') {
                                    echo "Lulus 'k'";
                                } elseif ($row['status'] === 'lulus_0') {
                                    echo "Lulus '0'";
                                } elseif ($row['status'] === 'tolak') {
                                    echo "Ditolak";
                                } else {
                                    echo "Sedang Diproses";
                                }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
