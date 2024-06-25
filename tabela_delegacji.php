<?php
include 'database.php';

$sql = "SELECT id, imie_nazwisko, data_od, data_do, miejsce_wyjazdu, miejsce_przyjazdu FROM delegacje";
$result = $conn->query($sql);


?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Tabela Delegacji BD</title>
</head>
<body>
    <h2>Tabela Delegacji BD</h2>
    <table>
        <thead>
            <tr>
                <th>Lp.</th>
                <th>Imię i Nazwisko</th>
                <th>Data od:</th>
                <th>Data do:</th>
                <th>Miejsce wyjazdu:</th>
                <th>Miejsce przyjazdu:</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php $lp = 1; ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $lp++; ?></td>
                        <td><?php echo htmlspecialchars($row["imie_nazwisko"]); ?></td>
                        <td><?php echo htmlspecialchars($row["data_od"]); ?></td>
                        <td><?php echo htmlspecialchars($row["data_do"]); ?></td>
                        <td><?php echo htmlspecialchars($row["miejsce_wyjazdu"]); ?></td>
                        <td><?php echo htmlspecialchars($row["miejsce_przyjazdu"]); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">0 results</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php $conn->close(); ?>

</body>
</html>